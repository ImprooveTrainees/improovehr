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

Route::get('/offices', 'OfficesDepsController@index');


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Auth::routes();
Route::get('/professional', 'ProfessionalInfoController@index');
Route::POST('/professional', 'ProfessionalInfoController@store');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/personal', 'UserController@index');
Route::get('/employees', 'UserController@employees');
Route::get('/absences', 'AbsenceController@index');
Route::post('/absences', 'AbsenceController@store');

Route::post('/editar', 'UserController@edit');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/holidays', function () {
    return view('holidays');
});
