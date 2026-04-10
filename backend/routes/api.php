<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PromoCodeController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PromoCodeAdminController;
use App\Http\Controllers\Admin\TicketAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques — frontend Nuxt
|--------------------------------------------------------------------------
*/
Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index']);
    Route::get('/{slug}', [TicketController::class, 'show']);
});

Route::get('/artists', function () {
    return response()->json([
        'data' => \App\Models\Artist::where('is_active', true)
            ->orderBy('display_order')
            ->orderBy('name')
            ->get(),
    ]);
});

Route::prefix('payments')->group(function () {
    Route::post('/initiate', [PaymentController::class, 'initiate']);
    Route::get('/{txRef}/status', [PaymentController::class, 'status']);
});

Route::post('/promo-codes/validate', [PromoCodeController::class, 'validate']);

/*
|--------------------------------------------------------------------------
| Webhooks — pas d'auth (vérification interne PayDunya)
|--------------------------------------------------------------------------
*/
Route::post('/webhooks/paydunya', [WebhookController::class, 'paydunya'])
    ->withoutMiddleware(['throttle:api']);

/*
|--------------------------------------------------------------------------
| Routes admin — protégées par Sanctum + middleware admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Gestion tickets
    Route::get('/tickets', [TicketAdminController::class, 'index']);
    Route::put('/tickets/{id}/stock', [TicketAdminController::class, 'updateStock']);
    Route::patch('/tickets/{id}/toggle', [TicketAdminController::class, 'toggle']);

    // Gestion tickets (CRUD complet)
    Route::post('/tickets', [TicketAdminController::class, 'store']);
    Route::put('/tickets/{id}', [TicketAdminController::class, 'update']);
    Route::post('/tickets/{id}', [TicketAdminController::class, 'update']); // multipart spoofing (_method=PUT)
    Route::delete('/tickets/{id}', [TicketAdminController::class, 'destroy']);

    // Gestion artistes
    Route::get('/artists', [ArtistController::class, 'index']);
    Route::post('/artists', [ArtistController::class, 'store']);
    Route::put('/artists/{id}', [ArtistController::class, 'update']);
    Route::post('/artists/{id}', [ArtistController::class, 'update']); // multipart spoofing (_method=PUT)
    Route::delete('/artists/{id}', [ArtistController::class, 'destroy']);
    Route::patch('/artists/{id}/toggle', [ArtistController::class, 'toggle']);

    // Gestion commandes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{txRef}', [OrderController::class, 'show']);
    Route::post('/orders/{txRef}/resend', [OrderController::class, 'resend']);

    // Scanner QR
    Route::get('/validate/{uid}', [OrderController::class, 'validateTicket']);

    // Gestion codes promo
    Route::get('/promo-codes', [PromoCodeAdminController::class, 'index']);
    Route::post('/promo-codes', [PromoCodeAdminController::class, 'store']);
    Route::put('/promo-codes/{id}', [PromoCodeAdminController::class, 'update']);
    Route::delete('/promo-codes/{id}', [PromoCodeAdminController::class, 'destroy']);
    Route::patch('/promo-codes/{id}/toggle', [PromoCodeAdminController::class, 'toggle']);
});

/*
|--------------------------------------------------------------------------
| Auth admin (token Sanctum)
|--------------------------------------------------------------------------
*/
Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if (!\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user->isAdmin()) {
        return response()->json(['message' => 'Accès refusé'], 403);
    }

    $token = $user->createToken('admin-token', ['admin'])->plainTextToken;

    return response()->json(['token' => $token, 'user' => $user]);
});

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Déconnecté']);
})->middleware('auth:sanctum');
