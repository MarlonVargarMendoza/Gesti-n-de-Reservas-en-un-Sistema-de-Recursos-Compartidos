<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ResourceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('resources')->group(function () {
    Route::resource('', ResourceController::class)->except('create', 'store', 'edit', 'update', 'destroy', 'show');
    Route::get('availability', [ResourceController::class, 'availability']);
});

Route::resource('reservations', ReservationController::class)->except('create', 'edit', 'update', 'index', 'show');