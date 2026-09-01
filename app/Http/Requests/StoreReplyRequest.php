<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
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
            'content.required' => 'Votre réponse est obligatoire.',
            'content.min' => 'Votre réponse doit contenir au moins 2 caractères.',
            'content.max' => 'Votre réponse ne peut pas dépasser 1000 caractères.',
        ];
    }
}
