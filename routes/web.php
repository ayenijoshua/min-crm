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

Route::get('companies/{paginate?}',[CompanyController::class, 'all'])->name('companies');

Route::group(['prefix' => 'admin','middleware'=>['auth']], function () {
    Route::get('dashboard',[UserController::class, 'index'])->name('admin.dashboard');

    Route::get('create-company',[CompanyController::class, 'create'])->name('admin.create-company');
    Route::post('store-company',[CompanyController::class, 'store'])->name('admin.store-company');
    Route::get('companies',[CompanyController::class, 'companies'])->name('admin.companies');
    Route::get('edit-company/{id}',[CompanyController::class, 'edit'])->name('admin.edit-company');
    Route::post('update-company/{id}',[CompanyController::class,'update'])->name('admin.update-company');
    Route::get('company/{id}',[CompanyController::class, 'company'])->name('admin.company');
    Route::delete('delete-company/{id}',[CompanyController::class, 'destroy'])->name('admin.delete-company');

    Route::get('create-user',[UserController::class, 'create'])->name('admin.create-user');
    Route::get('users',[UserController::class, 'users'])->name('admin.users');
    Route::get('all-users',[UserController::class, 'all'])->name('admin.all-users');
    Route::get('user/{id}',[UserController::class, 'user'])->name('admin.user');

    Route::post('store-user',[UserController::class, 'store'])->name('admin.store-user');
    Route::get('edit-user/{id}',[UserController::class, 'edit'])->name('admin.edit-user');
    Route::post('update-user/{id}',[UserController::class, 'update'])->name('admin.update-user');
    Route::delete('delete-user/{id}',[UserController::class, 'destroy'])->name('admin.delete-user');
});

Route::group(['prefix' => 'company','middleware'=>['']], function () {
    
    
});

require __DIR__.'/auth.php';
