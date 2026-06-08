<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // admin and companu owner
    Route::middleware('role:admin,company_owner')->group(function () {
        Route::resource('vacancies', VacancyController::class);
        Route::post('vacancies/{vacancy}/restore', [VacancyController::class, 'restore'])->name('vacancies.restore');
        Route::get('/apps', [AppController::class, 'index'])->name('apps.index');
        Route::get('/apps/{app}', [AppController::class, 'show'])->name('apps.show');
        Route::get('/apps/{app}/edit', [AppController::class, 'edit'])->name('apps.edit');
        Route::put('/apps/{app}', [AppController::class, 'update'])->name('apps.update');
        Route::delete('/apps/{app}', [AppController::class, 'destroy'])->name('apps.destroy');
        Route::post('/apps/{app}/restore', [AppController::class, 'restore'])->name('apps.restore');
    });

    // admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/restore', [CategoryController::class, 'restore'])->name('categories.restore');

        Route::resource('companies', CompanyController::class);
        Route::post('companies/{company}/restore', [CompanyController::class, 'restore'])->name('companies.restore');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    });

    // company owner
    Route::middleware('role:company_owner')->group(function () {
        Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
        Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
        Route::put('/my-company', [CompanyController::class, 'update'])->name('my-company.update');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
