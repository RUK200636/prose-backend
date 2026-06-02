<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\CartController;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Тестовый маршрут для проверки подключения к БД
Route::get('/test-db', function () {
    try {
        $pdo = DB::connection()->getPdo();
        return 'Connected to: ' . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Публичные маршруты (не требуют авторизации)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Защищённые маршруты (требуют валидный токен)
Route::middleware('auth:sanctum')->group(function () {
    // Пользователь
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Записи
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);

    // Корзина
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/{id}', [CartController::class, 'remove']);
});
