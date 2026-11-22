<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\MessageAdminController;
use App\Http\Controllers\Admin\SettingsAdminController;

/*
|--------------------------------------------------------------------------
| Routes Publiques — Full Service Point SARL
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/actualites', [BlogController::class, 'index'])->name('blog.index');
Route::get('/actualites/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Soumission du formulaire de contact & devis avec limitation de débit (5 soumissions / minute max)
Route::post('/contact/envoyer', [ContactController::class, 'submit'])
    ->middleware('throttle:5,1')
    ->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Routes d'Authentification Sécurisée (URL discrète, hors de vue publique)
|--------------------------------------------------------------------------
*/

Route::prefix('fsp-admin')->group(function () {
    // Écran de connexion sécurisé
    Route::get('/connexion', [AuthController::class, 'showLoginForm'])
        ->middleware('guest')
        ->name('login');

    // Traitement du formulaire d'authentification avec protection brute-force (5 tentatives / min)
    Route::post('/connexion', [AuthController::class, 'login'])
        ->middleware(['guest', 'throttle:5,1'])
        ->name('login.post');

    // Déconnexion sécurisée (invalidation de session et régénération du token CSRF)
    Route::post('/deconnexion', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Espace d'Administration & Gestion du CMS (Protégé par Middleware Auth & Admin)
|--------------------------------------------------------------------------
*/

Route::prefix('fsp-admin')
    ->middleware(['auth', 'admin.security'])
    ->name('admin.')
    ->group(function () {
        // Tableau de bord principal & KPIs
        Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');

        // Gestion du Blog & Articles (CRUD complet)
        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [BlogAdminController::class, 'index'])->name('index');
            Route::post('/', [BlogAdminController::class, 'store'])->name('store');
            Route::put('/{article}', [BlogAdminController::class, 'update'])->name('update');
            Route::delete('/{article}', [BlogAdminController::class, 'destroy'])->name('destroy');
            Route::patch('/{article}/statut', [BlogAdminController::class, 'toggleStatus'])->name('toggle');
        });

        // Gestion des Messages & Demandes de Devis
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [MessageAdminController::class, 'index'])->name('index');
            Route::patch('/{message}/statut', [MessageAdminController::class, 'toggleStatus'])->name('toggle');
            Route::delete('/{message}', [MessageAdminController::class, 'destroy'])->name('destroy');
        });

        // Paramètres Institutionnels & Rôles (Réservé au Super-Admin M. Narcisse KRA)
        Route::middleware('can:manage-system')->group(function () {
            Route::get('/parametres', [SettingsAdminController::class, 'index'])->name('settings.index');
            Route::post('/parametres', [SettingsAdminController::class, 'update'])->name('settings.update');
        });
    });
