<?php

namespace App\Http\Controllers;

use App\Report;
use App\absence;
use App\User;
use App\absenceType;
use Illuminate\Http\Request;
use Auth;
use DB;
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

        $listReports = Report::All();


        return view('/reports', compact('array_users','array_absences','listReports'));
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

        $user = Auth::user();
        $userid = Auth::id();

        $iduser = request('iduser');
        $absencetype = request('absencetype');
        $start_date = request('start_date');
        $end_date = request('end_date');


        $listAbsencesFiltered = absence::select('iduser','absencetype','end_date','start_date')->where('iduser',$iduser)->where('absencetype',$absencetype)->where('start_date','>=',$start_date)->where('end_date','<=',$end_date)->get();

        //$listAbsencesFiltered = DB::table('absences')->get();

        DB::table('reports')->delete();

        foreach($listAbsencesFiltered as $list) {

            $report = new Report();

            $id = $list->iduser;
            $type = $list->absencetype;
            $start = $list->start_date;
            $end = $list->end_date;

            $report->iduser=$id;
            $report->name="Diogo";
            $report->absencetype=$type;
            $report->description="Potes";
            $report->start_date=$start;
            $report->end_date=$end;



            $report->save();


        }



        return redirect('/reports');

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
