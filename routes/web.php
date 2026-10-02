<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\RegistrationController;

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

Route::post(
    'activities/{activity}/registrations',
    [RegistrationController::class, 'store']
)->name('activities.registrations.store');