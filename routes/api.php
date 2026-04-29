<?php

use Illuminate\Http\Request;
use App\Http\Controllers\MunicipalityController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/municipalities', [MunicipalityController::class, 'index']);