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





Route::group(['middleware' => ['auth']], function () {
        //Login
        Route::get('/', function () {
            return view('auth.login');
        });

        //Dashboard
        Route::get('/admin', 'AbsenceController@show');
        //
        //Users
        Route::get('/professional', function () {
            return view('professional_info');
        });
        Auth::routes();
        Route::get('/professional', 'ProfessionalInfoController@index');
        Route::POST('/storeimg', 'ProfessionalInfoController@store');
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/personal', 'UserController@index');
        Route::get('/employeesTeste', 'UserController@employees');
        Route::get('/holidays', 'AbsenceController@index')->middleware('roles');
        Route::post('/holidays', 'AbsenceController@store')->middleware('roles');
        Route::get('/absencesCount', 'AbsenceController@show');
        Route::get('/testeSlider', 'SliderController@index');
        Route::get('/newEmployee', 'UserController@newEmployeeView');
        Route::post('/newEmployeeRegister', 'UserController@newEmployeeRegister');
        Route::post('/saveProfileImage', 'UserController@storeProfileImg');
        Route::get('/editar', 'UserController@edit');
        Route::get('/profEdit', 'ProfessionalInfoController@edit');
        Route::get('/testeCalendar', 'FullCalendarController@index');
        Route::get('/employees', 'UserController@employees')->middleware('roles');     
        Route::get('/offices', 'OfficesDepsController@index');
        //

        //Harvest
        Route::get('/harvest', 'HarvestController@index');
        //

        //Evaluations AdminRH Create Evaluation
        Route::get('/evals', 'EvaluationsController@index')->middleware('roles');
        Route::get('/createSurvey', 'EvaluationsController@createSurvey');
        Route::get('/createArea', 'EvaluationsController@createArea');
        Route::get('/newSubCat', 'EvaluationsController@newSubCat');
        Route::get('/newQuestion', 'EvaluationsController@createQuestion');
        Route::get('/remQuestion', 'EvaluationsController@removeQuestion');
        Route::get('/areasPerSurveys', 'EvaluationsController@showAreasSurvey');
        Route::get('/addAreaToSurvey', 'EvaluationsController@addAreaToSurvey');
        Route::get('/deleteAreasSurvey', 'EvaluationsController@deleteAreasSurvey');
        Route::get('/surveysSubcat', 'EvaluationsController@surveysSubcat');
        Route::get('/addSubcatArea', 'EvaluationsController@addSubcatArea');
        Route::get('/remSubcatArea', 'EvaluationsController@removeSubcatArea');
        Route::get('/assignUser', 'EvaluationsController@assignUser');
        Route::get('/remUser', 'EvaluationsController@remUser');
        Route::get('/showSurvey', 'EvaluationsController@show');
        //

        //Evaluations AdminRH Evaluation Result 
        Route::get('/evalsResultsIndex', 'EvaluationsResults@index')->middleware('roles');
        Route::get('/showResults/{idSurvey}/{idUser}', 'EvaluationsResults@showResults')->middleware('roles');
        Route::get('/finalAverageAllSurveys', 'EvaluationsResults@finalAverageAllSurveys')->middleware('roles');
        Route::post('/finalCalculus', 'EvaluationsResults@finalAverageAllSurveys')->middleware('roles');
        //

        //Evaluations User Perspective
        Route::get('/indexUserEvals', 'EvaluationsUserPerspective@index');
        Route::get('/showSurveyUser/{id}', 'EvaluationsUserPerspective@showSurvey');
        Route::get('/storeAnswers', 'EvaluationsUserPerspective@storeAnswers');
        //

        //Settings
        Route::get('/settings', 'SettingController@index')->middleware('roles');
        Route::post('/saveSettings/{officeID}', 'SettingController@storeSettings')->middleware('roles');
        Route::get('/removeExtraDay/{idExtraDay}', 'SettingController@deleteExtraDay')->middleware('roles');
        //
        Route::get('/reports', 'ReportController@index');
        Route::get('/settingspage', 'SettingController@index')->middleware('roles');
        

});


Auth::routes();


// Route::get('/holidays', function () {
//     return view('holidays');
// });

// Route::get('/testeNumberHolidays', 'AbsenceController@show');



