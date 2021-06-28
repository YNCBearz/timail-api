<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::post('/users:logout', [PortalController::class, 'logout']);
