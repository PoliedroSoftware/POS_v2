<?php

use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\UserController;

Route::middleware('auth:api')->get('/user', [UserController::class, 'current']);

Route::get('/municipalities', [MunicipalityController::class, 'index']);