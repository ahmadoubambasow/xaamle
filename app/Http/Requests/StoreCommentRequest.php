<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => [
                'required',
                'string',
                'min:2',
                'max:1000',
            ],
        ];

    }

    public function messages(): array
    {
        return [
            'content.required' => 'Veuillez écrire un commentaire.',
            'content.min' => 'Le commentaire doit contenir au moins 2 caractères.',
            'content.max' => 'Le commentaire ne peut pas dépasser 1000 caractères.',
        ];
    }
    
}
