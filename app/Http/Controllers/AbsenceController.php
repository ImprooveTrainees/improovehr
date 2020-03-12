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

        $user = Auth::user();

        $id_user = Auth::user()->id;

        // DATE CALCULATION

        $contractDate = $user->contractUser->start_date;

        $currentDate = date("Y-m-d");

        $date1 = date_create($currentDate);
        $date2 = date_create($contractDate);

        $diff=date_diff($date1,$date2);
        $years = $diff->format("%Y%"); //format years
        // $months = $diff->format("%m%"); //format months

        // END DATE CALCULATION

        //$listVacationsUser = $user->userAbsence()->where('absencetype',1);

        $nrVacationsCY = $user->listAbsencesUserCY($id_user);

        $nrVacationsLY = $user->listAbsencesUserLY($id_user);

        $count_days = 0;

        $count_days2 = 0;

        foreach($nrVacationsCY as $vac) {

            $start = $vac->start_date;
            $end = $vac->end_date;

            if($start<='2019-12-31 23:59:59') {

                $start = '2020-01-02';

            }

            $date3 = date_create($start);
            $date4 = date_create($end);

            $diff_endstart = date_diff($date3,$date4);
            $days = $diff_endstart->format("%d%"); //format days

            $count_days += $days; //Number of vacation days already spent

        }

        $count_days += 1;

        foreach($nrVacationsLY as $vac) {

            $start2 = $vac->start_date;
            $end2 = $vac->end_date;

            if($start2<='2018-12-31 23:59:59') {

                $start2 = '2019-01-02';

            }

            $date5 = date_create($start2);
            $date6 = date_create($end2);

            $diff_endstart2 = date_diff($date5,$date6);
            $days2 = $diff_endstart2->format("%d%"); //format days

            $count_days2 += $days2; //Number of vacation days already spent

        }

        $count_days2 += 1;


        $vacation_days_current_year = 0;

        if($years<1){

            $months = $diff->format("%m%"); //format months

            $vacation_days_max = 2*$months;

            if($vacation_days_max>=20) {

                $vacation_days_max=20;

            }

        } else {

            if($count_days2<=22) {

                $balance = 22-$count_days2;

            }

            $vacation_days_max = 30;

            $vacations_days_per_year = 22;

            $vacations_total = $vacations_days_per_year+$balance;

            if($vacations_total>$vacation_days_max) {

                $vacations_total = 30;

            }

            $numberVacationsAvailable = $vacations_total - $count_days;


        }


        //VER USERCONTROLLER

        //User->ID
        //Contract->start_date
        //Current date
        //Nr of days per year : If (current date-start_date) < 1 year = 2xMonth (20days max)
        //Nr of days per year : If (current date-start_date) > 1 year = 2xMonth (22days) (30 max)
        //Vacations list (where absence type =1 and iduser=iduser)
        //Select all from 2019
        //Select all from 2020
        //FROM 2019 : (COUNT DAYS where status = concluded from '19) - Nr of days per year
        //FROM 2020 (current year): nr of days per year + 2019 (if current date<april) - (COUNT DAYS where status = concluded from '20)
        // return view('absences',compact('user','iduser'));

        // return view('testeNumberHolidays')->with('contractDate',$contractDate)->with('current_date',$current_date);
        return view('testeNumberHolidays',compact('user','years','nrVacationsCY','count_days','count_days2'));

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
