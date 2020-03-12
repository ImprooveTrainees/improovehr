<?php

namespace App\Http\Controllers;

use App\absence;
use App\User;
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

        $id_user= Auth::user()->id;

        $id_typeuser = $user->roles->id;

        $listAbsencesPending = $user->userAbsence()->where('status','Pending');

        $listAbsencesTotal = $user->userAbsence()->whereIn('status',['Concluded','Disapproved','Approved']);

        //$listAbsencesPending = absence::all()->where('status','Pending');

        //$listAbsencesTotal = DB::table('absences')->where('status','=','Concluded')->orWhere('status','=','Disapproved')->orWhere('status','=','Approved')->get();

        $absence = absence::select('absencetype','status','end_date','start_date','motive','attachment')->where('iduser', $id_user)->get();

        $array_vacations = array();

        $array_absences = array();

        foreach($absence as $abs) {

            if($abs->absencetype==1) {

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

        //$mssg = is('Admin');


        //$status = DB::table('absences')->where('iduser', $userid)->value('status');
        //$end_date = DB::table('absences')->where('iduser', $userid)->value('end_date');
        //$start_date = DB::table('absences')->where('iduser', $userid)->value('start_date');


        return view('absences',compact('user','array_vacations','array_absences','listAbsencesPending','listAbsencesTotal','id_typeuser'));
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
    public function store()
    {
        $userid = Auth::id();

        $vacation = new absence();

        $absence = new absence();

        $msg = '';

        $op = request('op');

        if($op==1) {

            $vacation->iduser=$userid;
            $vacation->absencetype=1;
            $vacation->attachment="";
            $vacation->status="Pending";
            $vacation->start_date = request('start_date');
            $vacation->end_date = request('end_date');
            $vacation->motive = "";


            $vacation->save();

            $msg='Vacation submitted. Waiting for approval.';


        } else if($op==2) {

            $absence->iduser=$userid;
            $absence->absencetype=request('type');
            $absence->attachment=request('attachment');
            $absence->status="Pending";
            $absence->start_date = request('start_date');
            $absence->end_date = request('end_date');
            $absence->motive = request('motive');


            $absence->save();

            $msg='Absence submitted. Waiting for approval.';

        }

        return redirect('/absences')->with('msgAbs',$msg);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $userLogado =  Auth::id();  
        $ausenciasDoUser = absence::where('iduser','=', $userLogado)
               ->where('absenceType', '!=' , 1)
               ->where('status', '=' , 'Concluded')
               ->select('*')
               ->get();

        $diasAusencia = 0;

        for($i = 0; $i < count($ausenciasDoUser); $i++) {
            $beginning = $ausenciasDoUser[$i]->start_date;
            $ending = $ausenciasDoUser[$i]->end_date;
            $date1=date_create($beginning);
            $date2=date_create($ending);
            $diff=date_diff($date1,$date2);
            $days = $diff->format("%d%");
            $diasAusencia += $days; 
        }    
        $diasAusencia += 1;
        return view('testeAbsencesCount')->with('absences', $diasAusencia);

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
    public function update()
    {
        $value = request('upd');

        $op = request('op');

        if($op==3) {

            DB::table('absences')
            ->where('id', $value)
            ->update(['status' => "Approved"]);

            $msg = "Absence approved with success.";


        } else if($op==4) {

            DB::table('absences')
            ->where('id', $value)
            ->update(['status' => "Disapproved"]);

            $msg = "Absence disapproved with success.";

        }

        return redirect('/absences')->with('msgAbs',$msg);

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
