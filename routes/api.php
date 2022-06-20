<?php

use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\PageApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppealApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('news',NewsApiController::class)->only([
    'index',
    'show',
]);

Route::apiResource('pages', PageApiController::class)->only([
    'index',
    'show',
]);

Route::apiResource('appeals', AppealApiController::class)->only([
    'store'
]);
