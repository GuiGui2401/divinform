<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\SettingController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\Admin\MediaController;

/*
|--------------------------------------------------------------------------
| API Routes — Ferme Divinform
|--------------------------------------------------------------------------
*/

// ── Authentification ────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('login',   [AuthController::class, 'login']);

    Route::middleware('auth.jwt')->group(function () {
        Route::post('logout',  [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me',       [AuthController::class, 'me']);
    });
});

// ── Public (sans authentification) ─────────────────────────────────────
Route::prefix('v1')->group(function () {

    // Catégories
    Route::get('categories',        [CategoryController::class, 'index']);
    Route::get('categories/{slug}', [CategoryController::class, 'show']);

    // Produits
    Route::get('products',              [ProductController::class, 'index']);
    Route::get('products/{slug}',       [ProductController::class, 'show']);
    Route::post('products/{id}/view',   [ProductController::class, 'trackView']);
    Route::post('products/{id}/contact',[ProductController::class, 'trackContact']);

    // Paramètres publics du site
    Route::get('settings', [SettingController::class, 'index']);
});

// ── Admin (JWT requis) ──────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth.jwt', 'role:super_admin,editor'])->group(function () {

    // Stats dashboard
    Route::get('stats', [AdminStatsController::class, 'index']);

    // Catégories
    Route::apiResource('categories', AdminCategoryController::class);

    // Produits
    Route::apiResource('products', AdminProductController::class);
    Route::post('products/{product}/images', [AdminProductController::class, 'uploadImages']);
    Route::delete('products/{product}/images/{index}', [AdminProductController::class, 'deleteImage']);

    // Téléversement d'images générique (tout admin authentifié)
    Route::post('uploads', [MediaController::class, 'upload']);

    // Paramètres (super_admin seulement)
    Route::middleware('role:super_admin')->group(function () {
        Route::get('settings',         [AdminSettingController::class, 'index']);
        Route::put('settings',         [AdminSettingController::class, 'update']);
        Route::post('settings/upload', [AdminSettingController::class, 'upload']);

        // Utilisateurs
        Route::apiResource('users', AdminUserController::class);
    });
});
