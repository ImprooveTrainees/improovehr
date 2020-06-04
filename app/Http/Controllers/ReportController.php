<?php

namespace App\Http\Controllers;

use App\Report;
use App\absence;
use App\User;
use App\absenceType;
use Illuminate\Http\Request;
use Auth;
use DB;
use Exporter;
use Redirect,Response;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $user = Auth::user();

        $id_user= Auth::user()->id;

        $allUsers = User::All();

        $array_users = array();

        array_push($array_users, 0, "All Employees");

        foreach($allUsers as $user) {

            $id = $user->id;
            $name = $user->name;

            array_push($array_users, $id, $name);

        }

        $listAbsencesTotal = absenceType::All(); // LIST ALL TYPE ABSENCES

        $array_absences = array();

        array_push($array_absences, 0, 'All Absences');

        foreach($listAbsencesTotal as $abs) {

            $id = $abs->absencetype;
            $name = $abs->description;

            array_push($array_absences, $id, $name);

        }

        /* $iduser2 = $request->session()->get('id_user');
        $typeabsence2 = $request->session()->get('type_absence');
        $start_date2 = $request->session()->get('startdate');
        $end_date2 = $request->session()->get('enddate'); */

        /* $iduser2 = 1;
        $typeabsence2 = 1;
        $start_date2 = "2020-06-07 00:00:00";
        $end_date2 = "2020-12-16 00:00:00"; */

        //$listAbsencesFiltered = DB::table('absences')->get();

        /* $listAbsencesFiltered = absence::select('iduser','absencetype','end_date','start_date')->where('iduser', $iduser2)->where('absencetype',$typeabsence2)->where('start_date','>=',$start_date2)->where('end_date','<=',$end_date2)->get();

        $arrayAbsencesFiltered = array();

        foreach($listAbsencesFiltered as $list) {

            $iduser = $list->iduser;
            $username = "admin";
            $absencetype = $list->absencetype;
            $absencetypename = "ferias";
            $startdate = $list->start_date;
            $enddate = $list->end_date;

            array_push($arrayAbsencesFiltered, $iduser, $username, $absencetype, $absencetypename ,$startdate, $enddate);

        } */

        //$listReports = Report::All();



        return view('/reports', compact('array_users','array_absences'));
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

    public function excel() {


        $listReports = DB::table('reports')->select('iduser','name','status','description','start_date','end_date');

        $excel = Exporter::make('Excel');

        $excel->loadQuery($listReports);

        $fileName = 'report.xlsx';

        return $excel->stream($fileName);

        //$report_array = array('IDUSER', 'USERNAME', 'STATUS', 'ABSENCE TYPE', 'START DATE', 'END DATE');


       /*  foreach($listReports as $list) {

            $report_array[]=array('IDUSER'=>$list->iduser,
            'USERNAME'=>$list->name,'STATUS'=>$list->status,
            'ABSENCE TYPE'=>$list->description,'START DATE'=>$list->start_date,
            'END_DATE'=>$list->end_date);


        }


        Excel::create('Report', function($excel) use ($report_array) {

            $excel->setTitle('Report');
            $excel->sheet('Report', function($sheet) use($report_array){

                $sheet->fromArray($report_array, 'Report', null, 'A1', false, false);

            });

        })->download('xlsx'); */


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

        $user = Auth::user();
        $userid = Auth::id();

        $iduser = request('iduser');
        $absencetype = request('absencetype');
        $start_date = request('start_date');
        $end_date = request('end_date');

        if($iduser == 0 && $absencetype == 0 && $start_date == '' && $end_date == '') {

            $listAbsencesFiltered = DB::table('absences')->join('users','absences.iduser','=','users.id')->join('absence_types','absences.absencetype','=','absence_types.id')->select('absences.*','absence_types.description','users.name')->orderBy('iduser','ASC')->orderBy('end_date','DESC')->get();


        } else if($start_date == '' && $end_date == '') {

            $listAbsencesFiltered = DB::table('absences')->join('users','absences.iduser','=','users.id')->join('absence_types','absences.absencetype','=','absence_types.id')->select('absences.*','absence_types.description','users.name')->where('absences.absencetype',$absencetype)->where('absences.iduser',$iduser)->orderBy('iduser','ASC')->orderBy('end_date','DESC')->get();

        } else if($iduser == 0 && $absencetype == 0) {

         $listAbsencesFiltered = DB::table('absences')->join('users','absences.iduser','=','users.id')->join('absence_types','absences.absencetype','=','absence_types.id')->select('absences.*','absence_types.description','users.name')->where('absences.start_date','>=',$start_date)->where('absences.end_date','<=',$end_date)->orderBy('iduser','ASC')->orderBy('end_date','DESC')->get();


        } else if($iduser == 0) {

        $listAbsencesFiltered = DB::table('absences')->join('users','absences.iduser','=','users.id')->join('absence_types','absences.absencetype','=','absence_types.id')->select('absences.*','absence_types.description','users.name')->where('absences.absencetype',$absencetype)->where('absences.start_date','>=',$start_date)->where('absences.end_date','<=',$end_date)->orderBy('iduser','ASC')->orderBy('end_date','DESC')->get();


        } else if($absencetype == 0) {

        $listAbsencesFiltered = DB::table('absences')->join('users','absences.iduser','=','users.id')->join('absence_types','absences.absencetype','=','absence_types.id')->select('absences.*','absence_types.description','users.name')->where('absences.iduser',$iduser)->where('absences.start_date','>=',$start_date)->where('absences.end_date','<=',$end_date)->orderBy('iduser','ASC')->orderBy('end_date','DESC')->get();


        } else {


            $listAbsencesFiltered = DB::table('absences')->join('users','absences.iduser','=','users.id')->join('absence_types','absences.absencetype','=','absence_types.id')->select('absences.*','absence_types.description','users.name')->where('absences.iduser',$iduser)->where('absences.absencetype',$absencetype)->where('absences.start_date','>=',$start_date)->where('absences.end_date','<=',$end_date)->orderBy('iduser','ASC')->orderBy('end_date','DESC')->get();

        }


        DB::table('reports')->delete();

        foreach($listAbsencesFiltered as $list) {

            $report = new Report();

            $id = $list->iduser;
            $start = $list->start_date;
            $end = $list->end_date;
            $type_name = $list->description;
            $user_name = $list->name;
            $status = $list->status;

            $report->iduser=$id;
            $report->name=$user_name;
            $report->status=$status;
            $report->description=$type_name;
            $report->start_date=$start;
            $report->end_date=$end;



            $report->save();


        }

        $listReports = Report::All();

        return view('/absenceReport', compact('listReports'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
