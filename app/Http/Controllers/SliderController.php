<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bdays = DB::table('users')->orderBy('birthDate', 'desc')->get();

        $bdaysDates = [];
        foreach($bdays as $birthdate){
            array_push($bdaysDates, $birthdate->name);
            array_push($bdaysDates, $birthdate->birthDate);
        }


        $contractsBegin = DB::table('users')
        ->join('contracts','users.id','=','contracts.iduser')
        ->select('users.name', 'contracts.start_date')
        ->orderBy('contracts.start_date', 'desc')
        ->get();
        $contractDates = [];

        foreach($contractsBegin as $contdate){
            array_push($contractDates, $contdate->name);
            array_push($contractDates, $contdate->start_date);
        }

        $absences = DB::table('users')
        ->join('absences', 'users.id', '=', 'absences.iduser')
        ->join('absence_types', 'absences.absencetype', '=', 'absence_types.id')
        ->where('absences.status', '=', 'Approved')
        ->select('users.name', 'absence_types.description','absences.status','absences.motive','absences.start_date','absences.end_date')
        ->orderBy('absences.start_date', 'desc')
        ->get();



        return view('testeSlider')->with('bdaysDates',$bdaysDates)->with('contractDates',$contractDates);
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
    public function store(Request $request)
    {
        //
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
