<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/profiles', [ProfileController::class, 'index']);
Route::get('/profiles/create', [ProfileController::class, 'create']);
Route::post('/profiles/store', [ProfileController::class, 'store']);
Route::get('/profiles/edit/{id}', [ProfileController::class, 'edit']);
Route::post('/profiles/update/{id}', [ProfileController::class, 'update']);
Route::get('/profiles/delete/{id}', [ProfileController::class, 'destroy']);
