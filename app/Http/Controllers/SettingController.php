<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\offices;
use Auth;
use App\User;
use App\settings_general;
use App\settings_extradays;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userAuth = Auth::user();
        $officeUserLogged = offices::where('adress', $userAuth->officeAdress)->first(); //fica preparado para vários offices no mesmo país
        //selecciona o first porque a morada aponta sempre para o id do escritorio certo
        $lastSettingsGeneral = settings_general::orderBy('created_at', 'desc')->first();
        $extraDays = settings_extradays::orderBy('extra_day', 'asc')->get();
        return view('settingspage')
        ->with('officeUserLogged', $officeUserLogged)
        ->with('lastSettingsGeneral', $lastSettingsGeneral)
        ->with('extraDays', $extraDays)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSettings($officeID, Request $request)
    {
        // 

        //office settings
        $officeSelected = offices::find($officeID);
        $usersSameAdress = User::where('officeAdress', $officeSelected->adress)->get();
        $officeSelected->description = $request->input('companyName');
        $officeSelected->adress = $request->input('companyAdress');
        foreach($usersSameAdress as $user) {
            $user->officeAdress = $request->input('companyAdress'); //muda a morada da empresa dos users da empresa que mudou a morada
            $user->save();
        } 
        $officeSelected->mail = $request->input('emailAdress');
        $officeSelected->contact = $request->input('contact');
        $officeSelected->save();
        // end office settings

        //flextime settings
        $newSettingsGeneral = new settings_general;
        $newSettingsGeneral->flextime_startDay = $request->input('startDay');
        $newSettingsGeneral->flextime_endDay = $request->input('endDay');
        $newSettingsGeneral->flextime_dailyHours = $request->input('hoursPerDay');
        $newSettingsGeneral->limit_vacations = $request->input('limitVacations');

        $newSettingsGeneral->alert_holidays = $request->input('holidaysAlert');
        $newSettingsGeneral->alert_birthdays = $request->input('BDaysAlert');
        $newSettingsGeneral->alert_evaluations = $request->input('evalsAlert');
        $newSettingsGeneral->alert_flextime = $request->input('flexAlert');
        $newSettingsGeneral->alert_notworking = $request->input('notWorkingAlert');
        $newSettingsGeneral->save();

        $datesSelected = $request->input('dateList');
        $datesSelectedDescription = $request->input('descriptionExtraDay');
        if($datesSelected != null) {
            for($i = 0; $i < count($datesSelected); $i++) {
                $newSettingsExtraDays = new settings_extradays;
                $newSettingsExtraDays->extra_day = $datesSelected[$i];
                $newSettingsExtraDays->description = $datesSelectedDescription[$i];
                $newSettingsExtraDays->save();
                 
             }
        }
     
        
        

        //end flextime settings




        $msg = "Preferences saved successfully";

        return redirect()->action('SettingController@index')
        ->with('msg', $msg);
        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteExtraDay($idExtraDay)
    {
        //
        settings_extradays::find($idExtraDay)->delete();
        $msg = "Extra day deleted successfully";

        return redirect()->action('SettingController@index')
        ->with('msg', $msg);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
