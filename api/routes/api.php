<?php

use App\Http\Controllers\JobController;
use App\Http\Middleware\ApiToken;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiToken::class)->group(function () {
    Route::get('/health-check', [JobController::class, 'healthCheck']);

    Route::post('/jobs', [JobController::class, 'create']);
    Route::get('/jobs/{id}', [JobController::class, 'show']);
    Route::delete('/jobs/{id}', [JobController::class, 'destroy']);
});
