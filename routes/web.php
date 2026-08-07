<?php

use App\Http\Controllers\CareersController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/process', [PageController::class, 'process'])->name('process');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/careers', [CareersController::class, 'index'])->name('careers.index');
Route::post('/careers/apply', [CareersController::class, 'apply'])
    ->name('careers.apply')
    ->middleware('throttle:10,1');
