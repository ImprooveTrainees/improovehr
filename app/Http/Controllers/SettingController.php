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

        return view('testeSettingsIndex')
        ->with('officeUserLogged', $officeUserLogged);
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
        $newSettingsGeneral->flextime_weeklyHours = $request->input('hoursPerWeek');
        $newSettingsGeneral->limit_vacations = $request->input('limit_vacations');

        $newSettingsExtraDays = new settings_extradays;
        $newSettingsExtraDays->extra_day = 
        //end flextime settings




        $msg = "Preferences saved successfully";

        return redirect()->action('SettingController@index')
        ->with('msg', $msg);
        ;


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
