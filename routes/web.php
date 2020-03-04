<?php

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

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/survey', function () {
    return view('survey');
});

Route::get('/testeAbsences', 'AbsenceController@index');
Route::get('/createVacations', 'AbsenceController@create');
Route::get('/createAbsences', 'AbsenceController@createAbs');
Route::post('/testeAbsences', 'AbsenceController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/personalInfo', 'PersonalInfoController@index');

Route::get('/professionalInfo', 'ProfessionalInfoController@index');

Route::get('/GeneralSettings', 'OfficesController@index');
Route::get('/employees', 'UserController@index');
