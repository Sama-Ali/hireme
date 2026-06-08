<?php

namespace App\Services;

use Exception;
use  Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Spatie\PdfToText\Pdf;
use OpenAI\Laravel\Facades\OpenAI;

class ResumeAnalysisService
{
    public function extractResumeData(string $storagePath)
    {
     try{
        // Extract data from the resume file
        $rowtext = $this->extractTextFromPDF($storagePath);

        Log::debug('Successfully extracted text from the file'. strlen($rowtext).'s');

        // use openai to extract the text into structure format
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a percise resume parser. Extract the information exactly as it in the resume without adding any other information. The output should be in JSON format.'],
                ['role' => 'user', 'content' => "Parse the following resume content and extract the information as a json object with the following keys: 'education', 'summary', 'skills', 'experience'. The resume content is: $rowtext . Return empty string if the key is not found."],
            ],
            'response_format' => [
                'type' => 'json_object',
            ],
            'temperature' => 0.1, // lower temperature for more precise output
        ]);

        // return the json object
        $result = $response->choices[0]->message->content;
        Log::debug('OpenAI response: '. $result);

        $parsedResult = json_decode($result, true);

        if(json_last_error() !== JSON_ERROR_NONE){
            Log::error('Failed to parse JSON: '. json_last_error_msg());
            throw new \Exception('Failed to parse JSON: '. json_last_error_msg());
        }

        return [
            'education' => $this->normalizeResumeField($parsedResult['education'] ?? ''),
            'summary' => $this->normalizeResumeField($parsedResult['summary'] ?? ''),
            'skills' => $this->normalizeResumeField($parsedResult['skills'] ?? ''),
            'experience' => $this->normalizeResumeField($parsedResult['experience'] ?? ''),
        ];
    } catch (\Exception $e){
        Log::error('Error extracting resume data: '. $e->getMessage());
        return [
            'education'=>'',
            'summary'=>'',
            'skills'=>'',
            'experience'=>'',
        ];
     }
    }

    private function normalizeResumeField(mixed $value): string
    {
        if (is_array($value)) {
            return implode('; ', array_map(fn ($item) => $this->normalizeResumeField($item), $value));
        }

        return $value === null ? '' : (string) $value;
    }

    private function extractTextFromPDF(string $storagePath): String
    {
        // Reading the file from cloud to local disk storage in temp file
        $tempFile = tempnam(sys_get_temp_dir(), 'resume');

        if (!Storage::disk('cloud')->exists($storagePath)) {
            throw new \Exception('File not found');
        }

        $pdfContent = Storage::disk('cloud')->get($storagePath);
        if (!$pdfContent){
            throw new \Exception('Failed to read file');
        }

        file_put_contents($tempFile, $pdfContent);

        // check if pdftotext is install
        $pdfTotextPath = ['/usr/local/bin/pdftotext', '/opt/homebrew/bin/pdftotext', '/usr/bin/pdftotext'];
        $pdfIsExists = false;

        foreach($pdfTotextPath as $path){
            if(file_exists($path)){
                $pdfIsExists=true;
                break;
            }
        }

        if(!$pdfIsExists){
            throw new \Exception('pdftotext is not installed');
        }

        // Extract text frm the file
        $text = (new Pdf())->setPdf($tempFile)->text();

        // Clean up the emp file
        unlink($tempFile);

        return $text;
    }

    public function aiEvaluate($vacancy, $resumeData){
        try{
            $jobDetails = json_encode([
                'title' => $vacancy->title,
                'description' => $vacancy->description, 
                'location' => $vacancy->location, 
                'salary' => $vacancy->salary, 
                'type' => $vacancy->type, 
            ]);
            $resumeDetails = json_encode($resumeData);

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => "You are an expert HR professional and job recruiter. 
                    You are given a job vacancy and a resume. 
                    The output should be in JSON format.
                    Your task in to analyze the resume and determine if the candidate is a good fit for the job.
                    The score should be a number between 0 and 100 for the candidate's fit for the job, and a detailed feedback.
                    Response should only be json that has the following keys: 'ai_score', 'ai_feedback'.
                    Ai feedback should be a detailed explanation of the score to the job and candidate's resume."
                    ],
                    ['role' => 'user', 'content' => "Evaluate the following job application. The job description is: $jobDetails and the resume is: $resumeDetails"],
                ],
                'response_format' => [
                    'type' => 'json_object',
                ],
                'temperature' => 0.1, // lower temperature for more precise output
            ]);
            $result = $response->choices[0]->message->content;
            Log::debug('OpenAI response: '. $result);

            $parsedResult = json_decode($result, true);

            if(!isset($parsedResult['ai_score']) || !isset($parsedResult['ai_feedback'])){
                Log::error('Failed to parse JSON: '. json_last_error_msg());
                throw new \Exception('Failed to parse JSON: '. json_last_error_msg());
            }

            return $parsedResult;

        } catch (\Exception $e){
            Log::error('Error evaluating resume: '. $e->getMessage());
            return [
                'ai_score' => 0,
                'ai_feedback' => 'Error evaluating resume '
            ];
        }
    }
}