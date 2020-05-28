<?php

namespace App\Http\Controllers;

use App\Report;
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
    public function index()
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

        foreach($listAbsencesTotal as $abs) {

            $id = $abs->absencetype;
            $name = $abs->description;

            array_push($array_absences, $id, $name);

        }



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
