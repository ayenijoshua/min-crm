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

Route::get('companies',[CompanyController::class, 'all']);

Route::group(['prefix' => 'admin','middleware'=>['auth']], function () {
    Route::get('dashboard',[UserController::class, 'index'])->name('admin.dashboard');
    Route::get('create-company',[CompanyController::class, 'create'])->name('admin.create-company');
    Route::get('create-user',[UserController::class, 'create'])->name('admin.create-user');
    Route::post('store-company',[CompanyController::class, 'store'])->name('admin.store-company');
    Route::post('store-user',[UserController::class, 'store'])->name('admin.store-user');
});

Route::group(['prefix' => 'company','middleware'=>['']], function () {
    
    
});

require __DIR__.'/auth.php';
