<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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

            // Supprimer l'ancien avatar de Cloudinary s'il existe
            if ($user->avatar) {
                try {
                    Cloudinary::uploadApi()->destroy(
                        $user->avatar
                    );
                } catch (\Throwable $e) {
                    // On ne bloque pas la mise à jour si l'ancien fichier n'est plus disponible
                }
            }

            // Envoyer le nouvel avatar vers Cloudinary
            $result = Cloudinary::uploadApi()->upload(
                $request->file('avatar')->getRealPath(),
                [
                    'folder' => 'xaamle/avatars',
                ]
            );

            // On conserve le public_id dans la base
            $data['avatar'] = $result['public_id'];
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
