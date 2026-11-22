<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Affiche l'écran de connexion sécurisé à l'administration.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite l'authentification avec validation stricte, protection CSRF et régénération de session.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'L\'adresse email professionnelle est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',
            'password.required' => 'Le mot de passe de sécurité est requis.',
        ]);

        $remember = $request->boolean('remember');

        // Tentative d'authentification avec protection contre le vol de session
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Journalisation de sécurité
            Log::info("Connexion réussie à l'administration FSP : {$user->name} ({$user->email}) depuis l'adresse IP {$request->ip()}");

            return redirect()->intended(route('admin.dashboard'));
        }

        // Journalisation de l'échec de connexion
        Log::warning("Tentative d'accès non autorisée à l'administration FSP pour {$request->input('email')} depuis l'IP {$request->ip()}");

        throw ValidationException::withMessages([
            'email' => ['Les identifiants fournis ne correspondent à aucun compte habilité.'],
        ]);
    }

    /**
     * Déconnexion sécurisée : invalidation totale de session et régénération du token CSRF.
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            Log::info("Déconnexion sécurisée de l'utilisateur : {$user->name} ({$user->email})");
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Votre session d\'administration a été fermée avec succès.');
    }
}
