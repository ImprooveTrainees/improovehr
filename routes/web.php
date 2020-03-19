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



Route::get('/professional', function () {
    return view('professional_info');
});

Route::get('/admin', 'AbsenceController@show');

Auth::routes();
Route::get('/professional', 'ProfessionalInfoController@index');
Route::POST('/storeimg', 'ProfessionalInfoController@store');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/personal', 'UserController@index');
Route::get('/employees', 'UserController@employees');
Route::get('/holidays', 'AbsenceController@index');
Route::post('/holidays', 'AbsenceController@store');
Route::get('/absencesCount', 'AbsenceController@show');

Route::get('/newEmployee', 'UserController@newEmployeeView');
Route::post('/newEmployeeRegister', 'UserController@newEmployeeRegister');

Route::get('/editar', 'UserController@edit');
Route::get('/profEdit', 'ProfessionalInfoController@edit');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/holidays', function () {
//     return view('holidays');
// });

// Route::get('/testeNumberHolidays', 'AbsenceController@show');

Route::get('/employees', function () {
    return view('employees');
});
