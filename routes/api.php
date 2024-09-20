<?php

use App\Http\Controllers\DashboardPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiPengurusController;
use App\Http\Controllers\UserController;


Route::get('/posts/data', [DashboardPostController::class, 'getData']);

Route::get('/pengurus', [ApiPengurusController::class, 'index']);