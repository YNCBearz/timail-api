<?php

use App\Http\Controllers\PortalController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {
        return $request->user();
    }
);

/**
 * Login API
 */
Route::post('/users:register', [PortalController::class, 'register']);
Route::post('/users:login', [PortalController::class, 'login']);

Route::group(
    [
        'middleware' => 'api',
    ],
    function ($router) {
        Route::post('/users:logout', [PortalController::class, 'logout']);
    }
);

