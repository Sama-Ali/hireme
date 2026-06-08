<?php

namespace App\Http\Requests;

use App\Models\Resume;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $resumeIds = Resume::query()
            ->where('user_id', auth()->id())
            ->pluck('id')
            ->all();

        return [
            'name' => ['required', 'string', 'max:255'],
            'resume_id' => ['required', 'string', Rule::in(array_merge(['new'], $resumeIds))],
            'cv' => ['required_if:resume_id,new', 'nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Your name is required.',
            'resume_id.required' => 'Please select a CV or choose to upload a new one.',
            'resume_id.in' => 'The selected CV is invalid.',
            'cv.required_if' => 'Please upload a CV file.',
            'cv.file' => 'The CV must be a valid file.',
            'cv.mimes' => 'The CV must be a PDF file.',
            'cv.max' => 'The CV must be less than 5MB.',
        ];
    }

}
