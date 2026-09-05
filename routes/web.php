<?php

use App\Http\Controllers\InterestController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/minat', [InterestController::class, 'create'])->name('interest.create');
Route::post('/minat', [InterestController::class, 'store'])->name('interest.store');
Route::get('/terima-kasih', [InterestController::class, 'thankYou'])->name('interest.thank-you');

Route::view('/admin', 'admin.index')->name('admin.index');
