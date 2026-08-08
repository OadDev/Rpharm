<?php

use App\Http\Controllers\CareersController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SetupController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/process', [PageController::class, 'process'])->name('process');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/careers', [CareersController::class, 'index'])->name('careers.index');
Route::post('/careers/apply', [CareersController::class, 'apply'])
    ->name('careers.apply')
    ->middleware('throttle:10,1');

Route::prefix('setup')->name('setup.')->group(function () {
    Route::get('/', [SetupController::class, 'welcome'])->name('welcome');
    Route::post('/', [SetupController::class, 'proceedFromWelcome'])->name('welcome.proceed');

    Route::get('/database', [SetupController::class, 'database'])->name('database');
    Route::post('/database', [SetupController::class, 'testAndSaveDatabase'])->name('database.save');

    Route::get('/install', [SetupController::class, 'install'])->name('install');
    Route::post('/install', [SetupController::class, 'runInstall'])->name('install.run');

    Route::get('/admin', [SetupController::class, 'admin'])->name('admin');
    Route::post('/admin', [SetupController::class, 'createAdmin'])->name('admin.create');

    Route::get('/finish', [SetupController::class, 'finish'])->name('finish');
});
