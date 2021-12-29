<?php

    use App\Http\Controllers\V1\Auth\LoginController;
    use App\Http\Controllers\V1\Auth\RegisterController;
    use App\Http\Controllers\V1\BalanceController;
    use App\Http\Controllers\V1\CarController;
    use App\Http\Controllers\V1\OrderController;
    use App\Http\Controllers\V1\ServiceController;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */

    Route::prefix('v1')->group(function () {
        Route::prefix('auth')->group(function () {
            Route::post('register', [RegisterController::class, 'register']);
            Route::post('login', [LoginController::class, 'login']);
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('orders', [OrderController::class, 'index']);
            Route::post('orders', [OrderController::class, 'store']);
            Route::get('services', [ServiceController::class, 'index']);
            Route::get('cars', [CarController::class, 'index']);
            Route::put('balance', [BalanceController::class, 'addBalance']);
        });
    });
