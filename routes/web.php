<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get(
    'activities/trash',
    [ActivityController::class, 'trash']
)->name('activities.trash');

Route::patch(
    'activities/{activity}/restore',
    [ActivityController::class, 'restore']
)->name('activities.restore');

Route::resource('activities', ActivityController::class);

Route::post(
    'activities/{activity}/publish',
    [ActivityController::class, 'publish']
)->name('activities.publish');

Route::post(
    'activities/{activity}/complete',
    [ActivityController::class, 'complete']
)->name('activities.complete');