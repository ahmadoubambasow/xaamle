<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire du profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Mettre à jour les informations du profil.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Récupérer les données validées
        $data = $request->validated();

        /*
         * Vérifier si l'adresse e-mail a été modifiée.
         * Dans ce cas, elle devra être vérifiée à nouveau.
         */
        if (
            isset($data['email']) &&
            $user->email !== $data['email']
        ) {
            $user->email_verified_at = null;
        }

        /*
         * Gestion de l'avatar
         */
        if ($request->hasFile('avatar')) {

            // Supprimer l'ancien avatar s'il existe
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Enregistrer le nouvel avatar
            $data['avatar'] = $request->file('avatar')
                ->store('avatars', 'public');
        }

        /*
         * Mettre à jour les informations
         */
        $user->fill($data);

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Supprimer le compte de l'utilisateur.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        /*
         * Supprimer l'avatar avant de supprimer l'utilisateur.
         */
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
