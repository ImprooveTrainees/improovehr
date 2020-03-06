<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});


Route::get('/personal', function () {
    return view('personal_info');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/personalInfo', 'UserController@index');
Route::get('/absences', 'AbsenceController@index');
Route::post('/absences', 'AbsenceController@store');
