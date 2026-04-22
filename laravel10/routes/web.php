<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DoctorService;
use App\Http\Controllers\ArticleService;
use App\Http\Controllers\TransactionService;
use App\Http\Controllers\CategoryController;

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

Route::get('/', function () {
    return view(view: 'welcomenew');
});
Route::get('/menu', function () {
    return view('menu');
});
Route::get('/menu/konsultasi', function () {
    return view('menu.konsultasi');
});
Route::get('/menu/janji', function () {
    return view('menu.janji');
});
Route::get('/admin/categories', function () {
    return view('admin.categories');
});
Route::get('/admin/order', function () {
    return view('admin.order');
});
Route::get('/admin/members', function () {
    return view('admin.members');
});
Route::get('/layouts/adminlte4', function () {
    return view('layouts.adminlte4');
});
Route::resource('services', ServiceController::class);
Route::resource('doctors', DoctorService::class);
Route::resource('transactions', TransactionService::class);
Route::resource('articles', ArticleService::class);
Route::get('/category/showExpensiveService', [CategoryController::class, 'showExpensiveService'])->name('category.expensiveservice');
//week7
Route::post("/category/showInfo", [CategoryController::class, 'showInfo'])->name("category.showInfo");
Route::post(
    "/category/showListServices",
    [CategoryController::class, 'showListServices']
)
    ->name("category.showListServices");
