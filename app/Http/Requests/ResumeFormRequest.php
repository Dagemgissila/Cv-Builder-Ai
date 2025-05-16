<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'degree.*' => 'required|string',
            'institution.*' => 'required|string',
            'start_date.*' => 'required|date',
            'end_date.*' => 'required|date',
            'position.*' => 'required|string',
            'company.*' => 'required|string',
            'start_date_exp.*' => 'required|date',
            'end_date_exp.*' => 'required|date',
            'description.*' => 'required|string',
            'skills.*' => 'required|string',
            'certifications.*' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'degree.*.required' => 'The Degree field in Education #:position is required.',

            'institution.*.required' => 'The Institution field in Education #:position is required.',
            'start_date.*.required' => 'The Start Date in Education #:position is required.',
            'end_date.*.required' => 'The End Date in Education #:position is required.',

            'position.*.required' => 'The Job position in Experience #:position is required.',
            'company.*.required' => 'The Company field in Experience #:position is required.',
            'start_date_exp.*.required' => 'The Start Date in Experience #:position is required.',
            'end_date_exp.*.required' => 'The End Date in Experience #:position is required.',
            'description.*.required' => 'The Description in Experience #:position is required.',

            'skills.*.required' => 'Each skill must be provided.',
            'certifications.*.required' => 'Each certification must be provided.',
        ];
    }

}
