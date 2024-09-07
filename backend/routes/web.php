<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin', [AdminController::class, 'index']);
Route::middleware('auth')->get('admin/list', [AdminController::class, 'list']);
Route::middleware('auth')->get('admin/item/{id}', [AdminController::class, 'item']);
Route::middleware('auth')->post('admin/item/{id}', [AdminController::class, 'edit']);
Route::middleware('auth')->get('admin/delete/{id}', [AdminController::class, 'delete']);

Route::post('admin/login', [AdminController::class, 'login']);