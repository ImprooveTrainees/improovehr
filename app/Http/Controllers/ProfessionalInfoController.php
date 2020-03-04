<?php

namespace App\Http\Controllers;

use App\professionalInfo;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\userattachments;
class ProfessionalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = Auth::id();
        $contract_id = DB::table('professional_infos')->where('user_id', $userid)->value('contract_id');
        $role = DB::table('contracts')->where('id',$contract_id)->value('position');
        $contractype = DB::table('contract_types')->where('id',$contract_id)->value('description');
        $department_id = DB::table('professional_infos')->where('user_id',$userid)->value('department_id');
        $department = DB::table('departments')->where('id',$department_id)->value('description');
        $startdate = DB::table('contracts')->where('id',$contract_id)->value('start_date');
        $endDate = DB::table('contracts')->where('id',$contract_id)->value('end_date');
        // $userAttachments =  DB::table('userattachments')->where('user_id',$userid)->value('files');
        $userAttachments = userattachments::select('files')->where('user_id',$userid)->get();


        return view('/testeProfessionalInfo',compact('contract_id','role','contractype','department','startdate','endDate','userAttachments'));

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
     * @param  \App\professionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function show(professionalInfo $professionalInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\professionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(professionalInfo $professionalInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\professionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, professionalInfo $professionalInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\professionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(professionalInfo $professionalInfo)
    {
        //
    }
}
