<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkerProfileRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'phone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'bio' => ['required', 'string', 'max:2000'],
            'skills' => ['required', 'string', 'max:1000'], // Sent as comma-separated string from form
            'linkedin' => ['nullable', 'nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?linkedin\.com\/.*$/i'],
            'facebook' => ['nullable', 'nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.*$/i'],
            'instagram' => ['nullable', 'nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.*$/i'],
        ];
    }

    /**
     * Custom messages for social links validation.
     */
    public function messages(): array
    {
        return [
            'linkedin.regex' => 'The LinkedIn URL must be a valid linkedin.com URL.',
            'facebook.regex' => 'The Facebook URL must be a valid facebook.com URL.',
            'instagram.regex' => 'The Instagram URL must be a valid instagram.com URL.',
        ];
    }
}
