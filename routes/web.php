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

Route::get('/logout', 'UserController@logout')->middleware('auth');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('auth');

Route::get('/survey', function () {
    return view('survey');
})->middleware('auth');

Route::get('/testeAbsences', 'AbsenceController@index')->middleware('auth');
Route::get('/createVacations', 'AbsenceController@create')->middleware('auth');
Route::get('/createAbsences', 'AbsenceController@createAbs')->middleware('auth');
Route::post('/testeAbsences', 'AbsenceController@store')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


Route::get('/personalInfo', 'PersonalInfoController@index')->middleware('auth');

Route::get('/professionalInfo', 'ProfessionalInfoController@index')->middleware('auth');

Route::get('/GeneralSettings', 'OfficesController@index')->middleware('auth');
Route::get('/employees', 'UserController@index')->middleware('auth');
