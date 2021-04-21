<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'admin','middleware'=>['auth']], function () {
    Route::get('dashboard',[UserController::class, 'index']);
    Route::post('create-company',[CompanyController::class, 'store']);
    Route::post('create-user',[UserController::class, 'store']);
});

require __DIR__.'/auth.php';
