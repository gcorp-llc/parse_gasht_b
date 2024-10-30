<?php

use App\Http\Controllers\Api\CountryController ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::apiResource('users', UserController::class);
Route::get('countries',[CountryController::class,'index']);
