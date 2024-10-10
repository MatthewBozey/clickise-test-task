<?php

use App\Http\Controllers\AddsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('users/list', [UserController::class, 'getUserList']);
Route::get('companies/list', [CompanyController::class, 'getCompaniesList']);
Route::apiResource('users', UserController::class)->parameters(['users' => 'id']);
Route::apiResource('companies', CompanyController::class)->parameters(['companies' => 'id']);
Route::apiResource('adds', AddsController::class)->parameters(['adds' => 'id']);
