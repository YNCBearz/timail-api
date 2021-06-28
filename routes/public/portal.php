<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::post('/users:register', [PortalController::class, 'register']);
Route::post('/users:login', [PortalController::class, 'login']);
