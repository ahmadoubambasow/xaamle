<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'avatar' => ['nullable', 'image', 'mimes: jpg,png,jpeg,webp', 'max:2048'],
            'bio' => ['nullable', 'string', 'max:500'],
        ];
    }

    /** 
     * * Messages de validation en français. 
     * */ 
    public function messages(): array 
    { 
        return [ 
            'name.required' => 'Le nom est obligatoire.', 
            'name.string' => 'Le nom doit être une chaîne de caractères.', 
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.', 
            'email.required' => 'L’adresse e-mail est obligatoire.', 
            'email.email' => 'Veuillez saisir une adresse e-mail valide.', 
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.', 
            'email.max' => 'L’adresse e-mail ne peut pas dépasser 255 caractères.', 
            'bio.string' => 'La biographie doit être un texte valide.', 
            'bio.max' => 'La biographie ne peut pas dépasser 500 caractères.', 
            'avatar.image' => 'Le fichier sélectionné doit être une image.', 
            'avatar.mimes' => 'L’avatar doit être au format JPG, PNG ou WebP.', 
            'avatar.max' => 'L’avatar ne doit pas dépasser 2 Mo.', 
        ]; 
    } 
    
    /** 
     * * Noms des attributs affichés dans les erreurs. 
     */ 
    public function attributes(): array 
    { 
        return [ 
            'name' => 'nom', 
            'email' => 'adresse e-mail', 
            'bio' => 'biographie', 
            'avatar' => 'avatar', 
        ]; 
    }
}
