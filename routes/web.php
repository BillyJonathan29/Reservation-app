<?php

use App\Http\Controllers\LoginController;
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

Route::group(['middleware' => 'guest'], function() {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('proses.login');
});

Route::group(['middleware' => 'auth'], function() {
    // Dashboard
    Route::redirect('/', 'dashboard');
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('import-templates/{filename}', [\App\Http\Controllers\DashboardController::class, 'templateImport'])->name('import_templates');
    Route::get('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

    // Setting Action
    Route::prefix('setting')->group(function(){
        Route::get('change_pasword', [\App\Http\Controllers\SettingController::class, 'viewChangePassword'])->name('setting.change_password');
        Route::put('{user}/change_pasword', [\App\Http\Controllers\SettingController::class, 'actionChangePassword'])->name('setting.save_password');
        Route::get('profile', [\App\Http\Controllers\SettingController::class, 'viewProfile'])->name('setting.profile');
        Route::put('{user}/profile', [\App\Http\Controllers\SettingController::class, 'actionProfile'])->name('setting.save_profile');
    });

    // Room Action 
    Route::prefix('room')->group(function () {
        Route::get('', [\App\Http\Controllers\RoomController::class, 'index'])->name('room');
        Route::post('store', [\App\Http\Controllers\RoomController::class, 'store'])->name('room.store');
        Route::post('import', [\App\Http\Controllers\RoomController::class, 'Import'])->name('room.import');
        Route::get('/{room}/get', [\App\Http\Controllers\RoomController::class, 'get'])->name('room.get');
        Route::put('/{room}/update', [\App\Http\Controllers\RoomController::class, 'update'])->name('room.update');
        Route::delete('/{room}/destroy', [\App\Http\Controllers\RoomController::class, 'destroy'])->name('room.destroy');
    });

    // Fnb Menu Action
    Route::prefix('fnb-menu')->group(function () {
        Route::get('', [\App\Http\Controllers\FnbMenuController::class, 'index'])->name('fnb-menu');
        Route::post('store', [\App\Http\Controllers\FnbMenuController::class, 'store'])->name('fnb-menu.store');
        Route::post('import', [\App\Http\Controllers\FnbMenuController::class, 'import'])->name('fnb-menu.import');
        Route::get('/{fnbMenu}/get', [\App\Http\Controllers\FnbMenuController::class, 'get'])->name('fnb-menu.get');
        Route::put('/{fnbMenu}/update', [\App\Http\Controllers\FnbMenuController::class, 'update'])->name('fnb-menu.update');
        Route::delete('/{fnbMenu}/destroy', [\App\Http\Controllers\FnbMenuController::class, 'destroy'])->name('fnb-menu.destroy');
    });

     // Facilities
    Route::prefix('facilitie')->group(function () {
        Route::get('', [\App\Http\Controllers\FacilitieController::class, 'index'])->name('facilitie');
        Route::post('store', [\App\Http\Controllers\FacilitieController::class, 'store'])->name('facilitie.store');
        Route::post('import', [\App\Http\Controllers\FacilitieController::class, 'import'])->name('facilitie.import');
        Route::get('/{facilitie}/get', [\App\Http\Controllers\FacilitieController::class, 'get'])->name('facilitie.get');
        Route::put('/{facilitie}/update', [\App\Http\Controllers\FacilitieController::class, 'update'])->name('facilitie.update');
        Route::delete('/{facilitie}/destroy', [\App\Http\Controllers\FacilitieController::class, 'destroy'])->name('facilitie.destroy');
    });

     // Room Facilities
    Route::prefix('room-facilitie')->group(function () {
        Route::get('', [\App\Http\Controllers\RoomFacilitieController::class, 'index'])->name('room-facilitie');
        Route::post('store', [\App\Http\Controllers\RoomFacilitieController::class, 'store'])->name('room-facilitie.store');
        Route::get('create', [\App\Http\Controllers\RoomFacilitieController::class, 'create'])->name('room-facilitie.create');
        Route::get('/{roomFacilitie}/edit', [\App\Http\Controllers\RoomFacilitieController::class, 'edit'])->name('room-facilitie.edit');
        Route::put('/{roomFacilitie}/update', [\App\Http\Controllers\RoomFacilitieController::class, 'update'])->name('room-facilitie.update');
        Route::delete('/{roomFacilitie}/destroy', [\App\Http\Controllers\RoomFacilitieController::class, 'destroy'])->name('room-facilitie.destroy');
    });


    // User Action
    Route::prefix('user')->group(function () {
        Route::get('', [\App\Http\Controllers\UserController::class, 'index'])->name('user');
        Route::post('store', [\App\Http\Controllers\UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/get', [\App\Http\Controllers\UserController::class, 'get'])->name('user.get');
        Route::put('/{user}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
        Route::delete('/{user}/destroy', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
    });
});