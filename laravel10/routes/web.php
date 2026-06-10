<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DoctorService;
use App\Http\Controllers\ArticleService;
use App\Http\Controllers\TransactionService;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;

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
    return view(view: 'layouts.adminlte4');
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
Route::resource("service", ServiceController::class);
// Route::resource("category", CategoryController::class);
Route::resource("transaction", TransactionService::class);
Route::post('/ajax/category/getEditForm', [CategoryController::class, 'getEditForm'])->name('category.getEditForm');
Route::post('/ajax/category/getEditFormB', [CategoryController::class, 'getEditFormB'])
->name('category.getEditFormB');
Route::post('/ajax/category/saveDataUpdate', [CategoryController::class, 'saveDataUpdate'])
->name('category.saveDataUpdate');
Route::post('/ajax/category/deleteData', [CategoryController::class, 'deleteData'])
->name('category.deleteData');
Route::post('/ajax/doctor/getEditFormB', [DoctorService::class, 'getEditFormB'])->name('doctor.getEditFormB');
Route::post('/ajax/doctor/saveDataUpdate', [DoctorService::class, 'saveDataUpdate'])->name('doctor.saveDataUpdate');
Route::post('/ajax/doctor/deleteData', [DoctorService::class, 'deleteData'])->name('doctor.deleteData');
Route::resource('doctor', DoctorService::class)->names('doctor');
Route::post('/ajax/article/getEditFormB', [ArticleService::class, 'getEditFormB'])->name('article.getEditFormB');
Route::post('/ajax/article/saveDataUpdate', [ArticleService::class, 'saveDataUpdate'])->name('article.saveDataUpdate');
Route::post('/ajax/article/deleteData', [ArticleService::class, 'deleteData'])->name('article.deleteData');
Route::resource('article', ArticleService::class)->names('article');
Route::resource('services', ServiceController::class);
Route::post('/ajax/services/getEditFormB', [ServiceController::class, 'getEditFormB'])->name('services.getEditFormB');
Route::post('/ajax/services/saveDataUpdate', [ServiceController::class, 'saveDataUpdate'])->name('services.saveDataUpdate');
Route::post('/ajax/services/deleteData', [ServiceController::class, 'deleteData'])->name('services.deleteData');
Route::resource('transactions', TransactionService::class);
Route::post('/ajax/transactions/getEditFormB', [TransactionService::class, 'getEditFormB'])->name('transactions.getEditFormB');
Route::post('/ajax/transactions/saveDataUpdate', [TransactionService::class, 'saveDataUpdate'])->name('transactions.saveDataUpdate');
Route::post('/ajax/transactions/deleteData', [TransactionService::class, 'deleteData'])->name('transactions.deleteData');

Auth::routes();
Route::middleware(["auth"])->group(function(){
  Route::resource("category", CategoryController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
