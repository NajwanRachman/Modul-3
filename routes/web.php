<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

Route::resource('activities', ActivityController::class);