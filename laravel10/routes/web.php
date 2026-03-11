<?php

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