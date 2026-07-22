<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\PrevisionController;
use App\Http\Controllers\GeeController;
use App\Http\Controllers\MeteoController;
use App\Http\Controllers\ParcelleController;
use App\Http\Controllers\SaisonController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\LegalController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [PrevisionController::class, 'accueil'])->name('accueil');

// Pages légales (publiques)
Route::get('/conditions-utilisation',    [LegalController::class, 'cgu'])->name('legal.cgu');
Route::get('/politique-confidentialite', [LegalController::class, 'politique'])->name('legal.politique');

// Avis publics
Route::get('/avis',    [ReviewController::class, 'publicPage'])->name('reviews.public');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.api');

// PWA manifest
Route::get('/manifest.json', function () {
    return response()->file(public_path('manifest.json'));
});

/*
|--------------------------------------------------------------------------
| Auth — Guest uniquement
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login',                  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',                 [AuthController::class, 'login']);
    Route::get('/register',               [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',              [AuthController::class, 'register']);
    Route::get('/forgot-password',        [ForgotPasswordController::class, 'showForm'])->name('password.request');
    Route::post('/forgot-password',       [ForgotPasswordController::class, 'sendLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showForm'])->name('password.reset');
    Route::post('/reset-password',        [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Google OAuth
|--------------------------------------------------------------------------
*/
Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| Vérification Email
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('dashboard')
            ->with('success', 'Email vérifié ! Bienvenue sur AgriPredict AI 🌾');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Lien de vérification renvoyé !');
    })->middleware('throttle:6,1')->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| APIs (auth requis)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/api/ndvi',  [GeeController::class, 'getNdvi'])->name('api.ndvi');
    Route::get('/api/meteo', [MeteoController::class, 'getMeteo'])->name('api.meteo');
});

/*
|--------------------------------------------------------------------------
| Routes User (auth + non admin + email vérifié)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'user', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PrevisionController::class, 'dashboard'])->name('dashboard');

    // Prévisions — page chargement + traitement
    Route::get('/formulaire',           [PrevisionController::class, 'index'])->name('formulaire');
    Route::get('/prevision/chargement', [PrevisionController::class, 'chargement'])->name('prevision.chargement');
    Route::post('/prevision',           [PrevisionController::class, 'prevoir'])->name('prevision.prevoir');

    // Parcelles
    Route::get('/listesparcelles',           [ParcelleController::class, 'index'])->name('parcelles.index');
    Route::get('/parcelles/create',          [ParcelleController::class, 'create'])->name('parcelles.create');
    Route::post('/parcelles',                [ParcelleController::class, 'store'])->name('parcelles.store');
    Route::get('/parcelles/{parcelle}/edit', [ParcelleController::class, 'edit'])->name('parcelles.edit');
    Route::put('/parcelles/{parcelle}',      [ParcelleController::class, 'update'])->name('parcelles.update');
    Route::delete('/parcelles/{parcelle}',   [ParcelleController::class, 'destroy'])->name('parcelles.destroy');

    // Saisons
    Route::get('/listessaisons',           [SaisonController::class, 'index'])->name('saisons.index');
    Route::get('/saisons/create',          [SaisonController::class, 'create'])->name('saisons.create');
    Route::post('/saisons',                [SaisonController::class, 'store'])->name('saisons.store');
    Route::get('/saisons/{saison}/edit',   [SaisonController::class, 'edit'])->name('saisons.edit');
    Route::put('/saisons/{saison}',        [SaisonController::class, 'update'])->name('saisons.update');
    Route::delete('/saisons/{saison}',     [SaisonController::class, 'destroy'])->name('saisons.destroy');
    Route::get('/saisons/infos-parcelle/{parcelle}', [SaisonController::class, 'infosParcelle'])
    ->name('saisons.infos-parcelle');

    // Historique
    Route::get('/historique',             [HistoriqueController::class, 'index'])->name('historique.index');
    Route::get('/historique/{prevision}', [HistoriqueController::class, 'show'])->name('historique.show');

    // Profil
    Route::get('/profil',          [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil',          [ProfilController::class, 'update'])->name('profil.update');
    Route::get('/profil/password', [ProfilController::class, 'showPassword'])->name('profil.password');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password.update');

    // Notifications
    Route::get('/notifications',         [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{n}/lu', [NotificationController::class, 'marquerLu'])->name('notifications.lu');
    Route::delete('/notifications',      [NotificationController::class, 'supprimerTout'])->name('notifications.vider');

    // Avis utilisateur
    Route::get('/mon-avis',    [ReviewController::class, 'myReviewPage'])->name('reviews.mine.page');
    Route::get('/reviews/mine',[ReviewController::class, 'myReview'])->name('reviews.mine');
    Route::post('/reviews',    [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews',     [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews',  [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Guide d'utilisation
    Route::get('/guide-utilisation', [LegalController::class, 'guide'])->name('legal.guide');
});

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',            [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/',                     [AdminController::class, 'index'])->name('index');
    Route::get('/users/{user}',         [AdminController::class, 'showUser'])->name('show_user');
    Route::get('/users/{user}/edit',    [AdminController::class, 'editUser'])->name('edit_user');
    Route::put('/users/{user}',         [AdminController::class, 'updateUser'])->name('update_user');
    Route::post('/users/{user}/toggle', [AdminController::class, 'toggleAdmin'])->name('toggle');
    Route::delete('/users/{user}',      [AdminController::class, 'destroyUser'])->name('destroy');
    Route::delete('/previsions/{prev}', [AdminController::class, 'destroyPrevision'])->name('destroy_prevision');

    // Modération des avis
    Route::get('/reviews',                        [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve',      [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject',       [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}',            [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
});