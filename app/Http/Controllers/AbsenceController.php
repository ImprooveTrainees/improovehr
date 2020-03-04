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

        $absence = absence::select('absence_type','status','end_date','start_date','motive','attachment')->where('id_user', $userid)->get();

        $array_vacations = array();

        $array_absences = array();

        foreach($absence as $abs) {



            if($abs->absence_type==1) {

            //LIST - VACATIONS

            $start = $abs->start_date;

            $end = $abs->end_date;

            $stat = $abs->status;


            $start = substr($start, 0,-9);
            $end = substr($end, 0,-9);

            array_push($array_vacations, $start, $end, $stat);

            } else {

                //LIST - ABSENCES

                $start = $abs->start_date;

                $end = $abs->end_date;

                $stat = $abs->status;

                $motive = $abs->motive;

                $attachment = $abs->attachment;

                array_push($array_absences,$start,$end,$stat,$attachment,$motive);

            }

        }


        //$status = DB::table('absences')->where('id_user', $userid)->value('status');
        //$end_date = DB::table('absences')->where('id_user', $userid)->value('end_date');
        //$start_date = DB::table('absences')->where('id_user', $userid)->value('start_date');


        return view('Absences.testeAbsences',compact('user','array_vacations','array_absences'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('Absences.createVacations');

    }

    public function createAbs()
    {
        //

        return view('Absences.createAbsences');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $userid = Auth::id();

        // error_log(request('start_date'));
        // error_log(request('end_date'));

        $vacation = new absence();

        $absence = new absence();

        $msg = '';

        $op = request('op');

        if($op==1) {

            $vacation->id_user=$userid;
            $vacation->absence_type=1;
            $vacation->attachment="";
            $vacation->status="Pending";
            $vacation->start_date = request('start_date');
            $vacation->end_date = request('end_date');
            $vacation->motive = "";


            $vacation->save();

            $msg='Vacation submitted. Waiting for approval.';


        } else {

            $absence->id_user=$userid;
            $absence->absence_type=request('type');
            $absence->attachment=request('attachment');
            $absence->status="Pending";
            $absence->start_date = request('start_date');
            $absence->end_date = request('end_date');
            $absence->motive = request('motive');


            $absence->save();

            $msg='Absence submitted. Waiting for approval.';

        }

        return redirect('/testeAbsences')->with('msgAbs',$msg);


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
