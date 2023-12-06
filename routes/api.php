<?php

use App\Http\Controllers\API\ProdiController as APIProdiController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\prodiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->get('/prodi', [prodiController::class, 'index']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('prodi', APIProdiController::class);
});
