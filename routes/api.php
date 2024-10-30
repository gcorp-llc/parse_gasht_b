<?php

use App\Http\Controllers\Api\CountryController ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::apiResource('users', UserController::class);

// OR

// Route::get('users', [UserController::class, 'index'])->name('users.collection');
// Route::post('users', [UserController::class, 'store'])->name('create.user');
// Route::get('users//{id}', [UserController::class, 'show'])->name('show.user');
// Route::put('users', [UserController::class, 'update'])->name('update.user');
// Route::delete('users/{id}', [UserController::class, 'destroy'])->name('delete.user');



Route::get('countries',[CountryController::class,'index']);
