<?php

use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
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

Route::prefix('payments')->group(function () {
    Route::post('/initiate', [PaymentController::class, 'initiate']);
    Route::get('/{txRef}/status', [PaymentController::class, 'status']);
});

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

    // Gestion commandes
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{txRef}', [OrderController::class, 'show']);
    Route::post('/orders/{txRef}/resend', [OrderController::class, 'resend']);

    // Scanner QR
    Route::get('/validate/{uid}', [OrderController::class, 'validateTicket']);
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
