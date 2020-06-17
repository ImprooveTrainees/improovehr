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



        //Login
Route::get('/', function () {
      return view('auth.login');
});

Route::group(['middleware' => ['auth']], function () {

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
        Route::get('/holidays', 'AbsenceController@index');
        Route::post('/holidays', 'AbsenceController@store');
        Route::get('/absencesCount', 'AbsenceController@show');
        Route::get('/testeSlider', 'SliderController@index');
        Route::get('/newEmployee', 'UserController@newEmployeeView')->middleware('generalAdminsRole');
        Route::post('/newEmployeeRegister', 'UserController@newEmployeeRegister')->middleware('generalAdminsRole');
        Route::post('/saveProfileImage', 'UserController@storeProfileImg');
        Route::get('/editar', 'UserController@edit');
        Route::get('/profEdit', 'ProfessionalInfoController@edit');
        Route::get('/testeCalendar', 'FullCalendarController@index');
        Route::get('/employees', 'UserController@employees');
        Route::get('/offices', 'OfficesDepsController@index');

        //

        //Admin, RH, Manager Routes 
        Route::get('/editProfessionalInfo', 'UserController@editProfessionalInfo')->middleware('generalAdminsRole');
        Route::get('/deleteEmployee/{id}', 'UserController@deleteEmployee')->middleware('generalAdminsRole');
        //

        //Harvest
        Route::get('/harvest', 'HarvestController@index');
        //

        //Evaluations AdminRH Create Evaluation
        Route::get('/evals', 'EvaluationsController@index')->middleware('generalAdminsRole');
        Route::get('/createSurvey', 'EvaluationsController@createSurvey')->middleware('generalAdminsRole');
        Route::get('/createArea', 'EvaluationsController@createArea')->middleware('generalAdminsRole');
        Route::get('/newSubCat', 'EvaluationsController@newSubCat')->middleware('generalAdminsRole');
        Route::get('/newQuestion', 'EvaluationsController@createQuestion')->middleware('generalAdminsRole');
        Route::get('/remQuestion', 'EvaluationsController@removeQuestion')->middleware('generalAdminsRole');
        Route::get('/areasPerSurveys', 'EvaluationsController@showAreasSurvey')->middleware('generalAdminsRole');
        Route::get('/addAreaToSurvey', 'EvaluationsController@addAreaToSurvey')->middleware('generalAdminsRole');
        Route::get('/deleteAreasSurvey', 'EvaluationsController@deleteAreasSurvey')->middleware('generalAdminsRole');
        Route::get('/surveysSubcat', 'EvaluationsController@surveysSubcat')->middleware('generalAdminsRole');
        Route::get('/addSubcatArea', 'EvaluationsController@addSubcatArea')->middleware('generalAdminsRole');
        Route::get('/remSubcatArea', 'EvaluationsController@removeSubcatArea')->middleware('generalAdminsRole');
        Route::get('/assignUser', 'EvaluationsController@assignUser')->middleware('generalAdminsRole');
        Route::get('/remUser', 'EvaluationsController@remUser')->middleware('generalAdminsRole');
        Route::get('/showSurvey', 'EvaluationsController@show')->middleware('generalAdminsRole');
        //

        //Evaluations AdminRH Evaluation Result
        Route::get('/evalsResultsIndex', 'EvaluationsResults@index')->middleware('generalAdminsRole');
        Route::get('/showResults/{idSurvey}/{idUser}', 'EvaluationsResults@showResults')->middleware('generalAdminsRole');
        Route::get('/finalAverageAllSurveys', 'EvaluationsResults@finalAverageAllSurveys')->middleware('generalAdminsRole');
        Route::post('/finalCalculus', 'EvaluationsResults@finalAverageAllSurveys')->middleware('generalAdminsRole');
        //

        //Evaluations User Perspective
        Route::get('/indexUserEvals', 'EvaluationsUserPerspective@index');
        Route::get('/showSurveyUser/{id}', 'EvaluationsUserPerspective@showSurvey');
        Route::get('/storeAnswers', 'EvaluationsUserPerspective@storeAnswers');
        //

        //Settings
        Route::get('/settings', 'SettingController@index')->middleware('generalAdminsRole');
        Route::post('/saveSettings/{officeID}', 'SettingController@storeSettings')->middleware('generalAdminsRole');
        Route::get('/removeExtraDay/{idExtraDay}', 'SettingController@deleteExtraDay')->middleware('generalAdminsRole');
        //
        //Reports
        Route::get('/reports', 'ReportController@index');
        Route::get('/settingspage', 'SettingController@index')->middleware('generalAdminsRole');
        Route::get('/reports/excel', 'ReportController@excel')->name('reports.excel');
        Route::post('/reports', 'ReportController@store');
        //
        //Teams
        Route::get('/newTeam', 'teamsController@create');
        Route::get('/showTeam', 'UserController@employees'); //mostra a equipa no employees
        Route::get('/addTeamMember', 'teamsController@addTeamMember');
        Route::get('/remTeamMember/{idUserRem}', 'teamsController@remTeamMember');
        //
        //Notifications
        Route::get('/readNotification', 'NotificationsUsersController@readNotification');
        //
});


Auth::routes();


// Route::get('/holidays', function () {
//     return view('holidays');
// });

// Route::get('/testeNumberHolidays', 'AbsenceController@show');



Route::get('/flextime', function () {
    return view('flextime');
});
