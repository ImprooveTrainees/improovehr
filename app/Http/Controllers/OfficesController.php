<?php

namespace App\Http\Controllers;

use App\offices;
use Illuminate\Http\Request;
use DB;
use Auth;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = Auth::id();
        $idDepartment = DB::table('users')->where('id', $userid)->value('iddepartment');
        $idOffice = DB::table('office_deps')->where('iddepartments', $idDepartment)->value('idoffice');
        $compName = DB::table('offices')->where('id', $idOffice)->value('description');
        $compAddress = DB::table('offices')->where('id', $idOffice)->value('adress');
        $compMail = DB::table('offices')->where('id', $idOffice)->value('mail');
        $compContact = DB::table('offices')->where('id', $idOffice)->value('contact');
        $compCountry = DB::table('offices')->where('id', $idOffice)->value('country');


        return view('/settings',compact('idDepartment','idOffice','compName','compAddress','compMail','compContact','compCountry'));


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
     * @param  \App\offices  $offices
     * @return \Illuminate\Http\Response
     */
    public function show(offices $offices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\offices  $offices
     * @return \Illuminate\Http\Response
     */
    public function edit(offices $offices)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\offices  $offices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, offices $offices)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\offices  $offices
     * @return \Illuminate\Http\Response
     */
    public function destroy(offices $offices)
    {
        //
    }
}
