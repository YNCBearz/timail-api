<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::delete('/users:logout', [PortalController::class, 'logout']);
