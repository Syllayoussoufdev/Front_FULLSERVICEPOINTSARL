<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticate
{
    /**
     * Filtre les requêtes entrantes pour s'assurer que seuls les utilisateurs authentifiés et accrédités accèdent au CMS.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérification de l'authentification
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Non authentifié.'], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Vérification de l'état actif du compte
        if (isset($user->is_active) && !$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->withErrors(['email' => 'Ce compte administrateur a été désactivé par la Direction.']);
        }

        // 3. Vérification des rôles autorisés (Admin ou Éditeur)
        if (!in_array($user->role, ['admin', 'editor'])) {
            abort(403, 'Accès non autorisé : Vous ne disposez pas des privilèges nécessaires pour accéder au CMS.');
        }

        // 4. Headers de sécurité renforcés pour l'administration (protection clickjacking & reniflage MIME)
        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        return $response;
    }
}
