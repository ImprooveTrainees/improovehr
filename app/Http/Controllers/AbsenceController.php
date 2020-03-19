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

        // $listAbsencesPending = $user->userAbsence()->where('status','Pending');

        // $listAbsencesTotal = $user->userAbsence()->whereIn('status',['Concluded','Disapproved','Approved']);

        $listVacationsTotal = $user->listVacations(); // LIST VACATIONS ALL USERS

        $listAbsencesTotal = $user->listAbsences(); // LIST ABSENCES ALL USERS

        $absence = absence::select('absencetype','status','end_date','start_date','motive','attachment')->where('iduser', $id_user)->get();

        $array_vacations = array();

        $array_absences = array();

        foreach($absence as $abs) {

            if($abs->absencetype==1) {

            //LIST - VACATIONS FROM AUTHENTICATED USER

            $start = $abs->start_date;

            $end = $abs->end_date;

            $stat = $abs->status;


            $start = substr($start, 0,-9);
            $end = substr($end, 0,-9);

            array_push($array_vacations, $start, $end, $stat);

            } else {

                //LIST - ABSENCES FROM AUTHENTICATED USER

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


        return view('holidays',compact('user','array_vacations','array_absences','listVacationsTotal','listAbsencesTotal'));
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
            $absence->absencetype="";
            $absence->attachment="";
            $absence->status="Pending";
            $absence->start_date = request('start_date');
            $absence->end_date = request('end_date');
            $absence->motive = "";


            $absence->save();

            $msg='Absence submitted. Waiting for approval.';

        }

        return redirect('/holidays');
        //->with('msgAbs',$msg);


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
        $dayCurrent = $date1->format("d"); // CURRENT DAY

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

        $dateEndCY = date('Y-12-31'); // DATE - END OF CURRENT YEAR

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

            $count_days += $days;

        }

        $count_days += 1; //Number of vacation days already spent this year

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

            $count_days2 += $days2;

        }

        $count_days2 += 1; //Number of vacation days already spent from last year


        $balance = 0;

        $vacationDaysCY = 0;
        $vacationDaysLY = 0;

        $vacations_days_per_year=0;
        $vacation_days_max=0;

        if($years<1){

            $vacationDaysLY = ((12 - $monthContract) + 1) * 2;    //MONTH DIFFERENCE BETWEEN BEGINNING CONTRACT AND END OF YEAR

            if($dayContract>=15) {

                $vacationDaysLY = $vacationDaysLY - 1;

            }

            if($yearContract==$yearCurrent) {

                $vacationDaysLY = 0;

            }


            $vacationDaysCY = ($monthCurrent - 1) * 2;       //MONTH DIFFERENCE BETWEEN MONTH CURRENT AND BEGINNING OF YEAR

            if($dayCurrent>=15) {

                $vacationDaysCY = $vacationDaysCY + 1;

            }

            $balanceLY = ($vacationDaysLY - $count_days2); // TOTAL DAYS LAST YEAR - DAYS SPENT LAST YEAR

            if($balanceLY < 0) {

                $balanceLY = 0;

            }

            $vacations_total = $vacationDaysCY + $balanceLY; // TOTAL DAYS

            $vacationDaysAvailable = $vacations_total - $count_days; // TOTAL AVAILABLE DAYS


        } else {

            if($yearContract!=($yearContract)-1) {

                $vacationDaysLY = 2 * 12;

            } else {

                $vacationDaysLY = 2 * ((12 - $monthContract) + 1);

            }


            $vacationDaysCY = 2 * 12;

        }

        $balanceLY = ($vacationDaysLY - $count_days2); // TOTAL DAYS LAST YEAR - DAYS SPENT LAST YEAR

        if($balanceLY < 0) {

            $balanceLY = 0;

        }

        $vacations_total = $vacationDaysCY + $balanceLY; // TOTAL DAYS

        $vacationDaysAvailable = $vacations_total - $count_days; // TOTAL AVAILABLE DAYS

        // $numberVacationsAvailable = $vacations_total - $count_days;

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

        return view('admin.dashboard',compact('vacationDaysAvailable','vacations_total','diasAusencia'));
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
