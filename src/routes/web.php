<?php

use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('tracking.index');
});

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking.index');
Route::get('/tracking/{delivery}', [TrackingController::class, 'show'])->name('tracking.show');

