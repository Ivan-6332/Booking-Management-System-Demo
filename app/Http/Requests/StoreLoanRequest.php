<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'loan_days' => 'nullable|integer|min:1|max:30',
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select a user.',
            'user_id.exists' => 'The selected user is invalid.',
            'loan_days.integer' => 'Loan days must be a valid number.',
            'loan_days.min' => 'Loan period must be at least 1 day.',
            'loan_days.max' => 'Loan period cannot exceed 30 days.',
            'notes.max' => 'Notes cannot exceed 500 characters.',
        ];
    }
}