<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormFieldController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\PageSectionController;
use App\Http\Controllers\Admin\TrackingSettingController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::view('/privasi', 'privacy')->name('privacy');
Route::get('/minat', [InterestController::class, 'create'])->name('interest.create');
Route::post('/minat', [InterestController::class, 'store'])->name('interest.store');
Route::get('/terima-kasih', [InterestController::class, 'thankYou'])->name('interest.thank-you');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'store'])->name('admin.login.store');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('index');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/account/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('/account/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export');
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');

    Route::get('/homepage', [PageSectionController::class, 'index'])->name('cms.index');
    Route::post('/homepage', [PageSectionController::class, 'store'])->name('cms.store');
    Route::put('/homepage/{section}', [PageSectionController::class, 'update'])->name('cms.update');
    Route::delete('/homepage/{section}', [PageSectionController::class, 'destroy'])->name('cms.destroy');

    Route::get('/form-minat', [FormFieldController::class, 'index'])->name('form-fields.index');
    Route::post('/form-minat', [FormFieldController::class, 'store'])->name('form-fields.store');
    Route::put('/form-minat/{field}', [FormFieldController::class, 'update'])->name('form-fields.update');
    Route::delete('/form-minat/{field}', [FormFieldController::class, 'destroy'])->name('form-fields.destroy');

    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    Route::get('/tracking', [TrackingSettingController::class, 'edit'])->name('tracking.edit');
    Route::put('/tracking', [TrackingSettingController::class, 'update'])->name('tracking.update');
});
