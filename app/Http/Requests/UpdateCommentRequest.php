<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Autorisation de la requête.
     */
    public function authorize(): bool
    {
        return $this->user()?->can(
            'update',
            $this->route('comment')
        ) ?? false;
    }

    /**
     * Règles de validation.
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

    /**
     * Messages personnalisés.
     */
    public function messages(): array
    {
        return [
            'content.required' => 'Veuillez écrire un commentaire.',
            'content.min' => 'Votre commentaire doit contenir au moins 2 caractères.',
            'content.max' => 'Votre commentaire ne peut pas dépasser 1000 caractères.',
        ];
    }
}
