<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\NewsWebController;
use App\Http\Controllers\Web\OAuthController;
use App\Http\Controllers\Web\PageWebController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AppealController;
use App\Http\Controllers\Web\CategoriesController;

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

Route::get('/profile', [ProfileController::class, 'show'])
    ->name('profile')
    ->middleware('auth');


Route::get('/login', [AuthController::class, 'loginForm'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::get('/register', [AuthController::class, 'registerForm'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::prefix('/oauth')->group(function () {
    Route::get('/{provider}/redirect', [OAuthController::class, 'redirectToService'])->name('oauth.redirect');
    Route::get('/{provider}/login', [OAuthController::class, 'login'])->name('oauth.login');
});

Route::get('/catalog/{slug?}', [CategoriesController::class, 'index'])
    ->name('catalog');

Route::get('/catalog/product/{slug}', [ProductController::class, 'index'])
    ->name('product');

Route::get('/cart', CartController::class)->middleware('auth.optional');
