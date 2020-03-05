<?php

namespace App\Http\Controllers;

use App\personalInfo;
use Illuminate\Http\Request;
use DB;
use Auth;
class PersonalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = Auth::id();
        $userName = DB::table('users')->where('id', $userid)->value('name');
        $Bdate = DB::table('personal_infos')->where('user_id', $userid)->value('birth_date');
        $Email = DB::table('users')->where('id', $userid)->value('email');

        $status = DB::table('personal_infos')->where('user_id', $userid)->value('status');
        $nif = DB::table('personal_infos')->where('user_id', $userid)->value('tax_number');
        $academicQual = DB::table('personal_infos')->where('user_id', $userid)->value('academic_qual');
        $mobile = DB::table('personal_infos')->where('user_id', $userid)->value('phone');
        $address = DB::table('personal_infos')->where('user_id', $userid)->value('address');
        $zip = DB::table('personal_infos')->where('user_id', $userid)->value('zip_code');
        $city = DB::table('personal_infos')->where('user_id', $userid)->value('city');
        $iban = DB::table('personal_infos')->where('user_id', $userid)->value('iban');

        $actualYear = date("Y/m/d");
        $date1=date_create($Bdate);
        $date2=date_create($actualYear);
        $diff=date_diff($date1,$date2);
        $age = $diff->format("%Y%"); //formato anos

        return view('/personal_info',compact('userName','Bdate','Email','status','age','nif', 'academicQual','mobile','address','zip','city','iban'));

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
     * @param  \App\personalInfo  $personalInfo
     * @return \Illuminate\Http\Response
     */
    public function show(personalInfo $personalInfo)
    {
        //



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\personalInfo  $personalInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(personalInfo $personalInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\personalInfo  $personalInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, personalInfo $personalInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\personalInfo  $personalInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(personalInfo $personalInfo)
    {
        //
    }
}
