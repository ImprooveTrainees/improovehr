<?php

namespace App\Http\Controllers;

use App\absence;
use Illuminate\Http\Request;
use Auth;
use DB;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $userid = Auth::id();

        $absences = absence::all();

        $absence = absence::select('status','end_date','start_date')->where('id_user', $userid)->get();

        $array_abs = array();

        foreach($absence as $abs) {

            $start = $abs->start_date;

            $end = $abs->end_date;

            $stat = $abs->status;



            $start = substr($start, 0,-9);
            $end = substr($end, 0,-9);

            array_push($array_abs, $start, $end, $stat);



        }


        //$new_date = date("Y-m-d H:i:s",strtotime($date_time));

        //$holiday_row = absence::whereId($query)->get();


        //$status = DB::table('absences')->where('id_user', $userid)->value('status');
        //$end_date = DB::table('absences')->where('id_user', $userid)->value('end_date');
        //$start_date = DB::table('absences')->where('id_user', $userid)->value('start_date');




        return view('/testeAbsences',compact('user','array_abs'));
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
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show(absence $absence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function edit(absence $absence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, absence $absence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(absence $absence)
    {
        //
    }
}
