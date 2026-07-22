<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Rediriger si déjà connecté
        if (auth()->check()) {
            return auth()->user()->is_admin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            Auth::user()->update(['last_login_at' => now()]);

            // Redirection selon le rôle
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue Administrateur !');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Connexion réussie !');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        // Rediriger si déjà connecté
        if (auth()->check()) {
            return auth()->user()->is_admin
                ? redirect()->route('admin.dashboard')
                : redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email:rfc,dns',
                'unique:users,email',
                'max:255',
            ],
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'last_login_at' => now(),
        ]);

        Auth::login($user);

        // Envoyer email de vérification
        $user->sendEmailVerificationNotification();

        return redirect('/email/verify')
            ->with('success', 'Compte créé ! Vérifiez votre email pour activer votre compte.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Déconnexion réussie.');
    }
}