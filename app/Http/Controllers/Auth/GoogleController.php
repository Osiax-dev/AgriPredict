<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Rediriger vers Google
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // Callback après authentification Google
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Chercher ou créer l'utilisateur
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Mettre à jour google_id si connexion par email existante
                $user->update([
                    'google_id'     => $googleUser->getId(),
                    'avatar'        => $googleUser->getAvatar(),
                    'last_login_at' => now(),
                ]);
            } else {
                // Créer un nouveau compte
                $user = User::create([
                    'name'          => $googleUser->getName(),
                    'email'         => $googleUser->getEmail(),
                    'google_id'     => $googleUser->getId(),
                    'avatar'        => $googleUser->getAvatar(),
                    'password'      => bcrypt(str()->random(24)),
                    'last_login_at' => now(),
                ]);
            }

            Auth::login($user, true); // true = remember me

            // Redirection selon le rôle
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue Administrateur !');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Connexion Google réussie ! Bienvenue ' . $user->name);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Erreur de connexion Google : ' . $e->getMessage());
        }
    }
}