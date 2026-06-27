<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'full_name'    => ['required', 'string', 'max:150'],
            'email'        => ['required', 'email:rfc', 'max:200'],
            'phone'        => ['nullable', 'string', 'max:30'],
            'cover_letter' => ['nullable', 'string', 'max:3000'],
            'resume'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
            'resume.max'   => 'Resume file size must not exceed 5 MB.',
        ];
    }
}
