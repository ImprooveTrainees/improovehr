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

        $yearCurrent = $date1->format("Y");
        $yearContract = $date2->format("Y"); // YEAR OF CONTRACT

        $monthContract = $date2->format("m"); //MONTH OF CONTRACT
        $dayContract = $date2->format("d"); // DAY OF CONTRACT

        $monthCurrent = $date1->format("m"); // CURRENT MONTH

        $diff=date_diff($date1,$date2);
        $years = $diff->format("%Y%"); //format years
        $months = $diff->format("%m%"); //format months

        // END DATE CALCULATION

        //$listVacationsUser = $user->userAbsence()->where('absencetype',1);

        $nrVacationsCY = $user->listAbsencesUserCY($id_user);

        $nrVacationsLY = $user->listAbsencesUserLY($id_user);

        $count_days = 0;

        $count_days2 = 0;

        $dateEndLY = date('Y-12-31', strtotime('- 1 year')); // DATE - END OF LAST YER

        $dateStartCY = date('Y-01-01'); // DATE - START OF CURRENT YEAR

        $dateStartLY = date('Y-01-01', strtotime('- 1 year')); // DATE - START OF LAST YEAR

        $dateEnd2Y = date('Y-12-31', strtotime('- 2 year')); // DATE - END OF 2 YEARS AGO

        foreach($nrVacationsCY as $vac) {

            $start = $vac->start_date;
            $end = $vac->end_date;

            if($start<=$dateEndLY) {

                $start = $start_year;

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

            if($start2<=$dateEnd2Y) {

                $start2 = $dateStartLY;

            }

            $date5 = date_create($start2);
            $date6 = date_create($end2);

            $diff_endstart2 = date_diff($date5,$date6);
            $days2 = $diff_endstart2->format("%d%"); //format days

            $count_days2 += $days2; //Number of vacation days already spent

        }

        $count_days2 += 1;

        $balance = 0;

        if($years<1){

            $vacations_days_per_year=20;

            $vacation_days_max=20;

            $monthsLeft = 12 - $monthContract + 1;

                if($dayContract<15) {

                    $vacation_daysLY = 2*$monthsLeft;


                } else if($dayContract>=15) {

                    $vacation_daysLY = 2*$monthsLeft - 1;

                }

            if($yearContract!=$yearCurrent) {

                $balance = $vacation_daysLY - $count_days2;

                $vacations_total = ($balance+$vacations_days_per_year);

            } else {

                $vacations_total=$vacation_daysLY;

            }

            if($vacations_total>$vacation_days_max) {

                $vacations_total = 20;

            }


        } else {

            $vacations_days_per_year = 22;

            $vacation_days_max = 30;

            if($count_days2<=$vacations_days_per_year) {

                $balance = $vacations_days_per_year-$count_days2;

            }

            if($monthCurrent>=5) {

                $balance=0;

            }

            $vacations_total = $vacations_days_per_year+$balance;

            if($vacations_total>$vacation_days_max) {

                $vacations_total = 30;

            }

        }

        $numberVacationsAvailable = $vacations_total - $count_days;

        // return view('admin.dashboard',compact('numberVacationsAvailable','vacations_total'));
        // return view('testeNumberHolidays',compact('numberVacationsAvailable','vacations_total'));
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

        return view('admin.dashboard',compact('numberVacationsAvailable','vacations_total','diasAusencia'));
        // return view('testeAbsencesCount')->with('absences', $diasAusencia);

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
