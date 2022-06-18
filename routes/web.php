<?php

use App\Http\Controllers\Web\NewsWebController;
use App\Http\Controllers\Web\PageWebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AppealController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/page/{slug}', PageWebController::class);

Route::get('/news', [NewsWebController::class, 'index']);
Route::get('/news/{slug}', [NewsWebController::class, 'show']);

Route::get('/appeal', [AppealController::class, 'form'])->name('appeal.form');
Route::post('/appeal', [AppealController::class, 'send'])->name('appeal.send');

//Route::match(['get', 'post'], '/appeal', AppealController::class)->name('appeal');
