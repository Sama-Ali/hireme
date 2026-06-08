<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyRequest;
use App\Models\App;
use App\Models\Resume;
use App\Models\Vacancy;
use App\Services\ResumeAnalysisService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VacancyController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function show(Vacancy $vacancy)
    {
        $vacancy->load(['company', 'category']);

        $hasApplied = $this->userHasApplied($vacancy);

        return view('vacancy.show', compact('vacancy', 'hasApplied'));
    }

    public function applyNow(Vacancy $vacancy)
    {
        $vacancy->load(['company', 'category']);

        $hasApplied = $this->userHasApplied($vacancy);
        $user = auth()->user();
        $resumes = $user->resumes()->latest()->get();

        return view('vacancy.applyNow', compact('vacancy', 'hasApplied', 'user', 'resumes'));
    }

    public function storeApply(ApplyRequest $request, Vacancy $vacancy)
    {
        if ($this->userHasApplied($vacancy)) {
            return redirect()
                ->route('vacancies.apply', $vacancy)
                ->with('status', __('You have already applied for this job.'));
        }

        $validated = $request->validated();
        $path = null;

        try {
            if ($validated['resume_id'] === 'new') {
                $file = $request->file('cv');
                $extension = $file->getClientOriginalExtension();
                $originalName = $file->getClientOriginalName();
                $fileName = 'cv_'.time().'.'.$extension;

                $path = $file->storeAs('cvs', $fileName, 'cloud');

                $extractedInfo = $this->resumeAnalysisService->extractResumeData($path);
                $resumeAttributes = [
                    'user_id' => auth()->id(),
                    'name' => $originalName,
                    'url' => $path,
                    'contact' => "Name: {$validated['name']}, Email: ".auth()->user()->email,
                    'education' => $extractedInfo['education'],
                    'summary' => $extractedInfo['summary'],
                    'skills' => $extractedInfo['skills'],
                    'experience' => $extractedInfo['experience'],
                ];
            } else {
                $resume = Resume::query()
                    ->where('user_id', auth()->id())
                    ->findOrFail($validated['resume_id']);

                $extractedInfo = [
                    'education' => $resume->education,
                    'summary' => $resume->summary,
                    'skills' => $resume->skills,
                    'experience' => $resume->experience,
                ];
                $resumeAttributes = null;
            }

            $evaluation = $this->resumeAnalysisService->aiEvaluate($vacancy, $extractedInfo);

            DB::transaction(function () use ($vacancy, $resumeAttributes, $evaluation, &$resume) {
                if ($resumeAttributes !== null) {
                    $resume = Resume::create($resumeAttributes);
                }

                App::create([
                    'user_id' => auth()->id(),
                    'vacancy_id' => $vacancy->id,
                    'resume_id' => $resume->id,
                    'status' => 'pending',
                    'ai_score' => $evaluation['ai_score'],
                    'ai_feedback' => $evaluation['ai_feedback'],
                ]);
            });

            return redirect()
                ->route('apps.index')
                ->with('success', __('Application submitted successfully.'));
        } catch (QueryException $e) {
            if ($this->isDuplicateApplicationError($e)) {
                if ($path) {
                    Storage::disk('cloud')->delete($path);
                }

                return redirect()
                    ->route('vacancies.apply', $vacancy)
                    ->with('status', __('You have already applied for this job.'));
            }

            if ($path) {
                Storage::disk('cloud')->delete($path);
            }

            throw $e;
        } catch (\Throwable $e) {
            if ($path) {
                Storage::disk('cloud')->delete($path);
            }

            throw $e;
        }
    }

    private function userHasApplied(Vacancy $vacancy): bool
    {
        return App::query()
            ->where('user_id', auth()->id())
            ->where('vacancy_id', $vacancy->id)
            ->exists();
    }

    private function isDuplicateApplicationError(QueryException $e): bool
    {
        return $e->getCode() === '23000' || str_contains($e->getMessage(), 'Duplicate entry');
    }
}
