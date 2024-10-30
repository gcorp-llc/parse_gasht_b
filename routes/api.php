<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CountryController;

Route::apiResource('users', UserController::class);
Route::get('countries',[CountryController::class,'index']);
