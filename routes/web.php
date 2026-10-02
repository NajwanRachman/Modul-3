<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::resource('activities', ActivityController::class);

Route::post(
    'activities/{activity}/publish',
    [ActivityController::class, 'publish']
)->name('activities.publish');

Route::post(
    'activities/{activity}/complete',
    [ActivityController::class, 'complete']
)->name('activities.complete');