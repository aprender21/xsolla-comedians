<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/comedian', [\App\Http\Controllers\Api\ComediansController::class, 'index'])
    ->name('api.comedian.list');

Route::post('/comedian', [\App\Http\Controllers\Api\ComediansController::class, 'create'])
    ->name('api.comedian.create');

Route::put('/comedian/{id}', [\App\Http\Controllers\Api\ComediansController::class, 'update'])
    ->name('api.comedian.update');

Route::delete('/comedian/{id}', [\App\Http\Controllers\Api\ComediansController::class, 'destroy'])
    ->name('api.comedian.delete');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
