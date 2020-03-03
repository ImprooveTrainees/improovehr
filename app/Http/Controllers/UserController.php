<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$userid = Auth::id();
        $dados = User::All();
        $arrayInfo = [];
        for($i = 0; $i < count($dados); $i++) {
            $userID = $dados[$i]->id;
            array_push($arrayInfo, "foto");
            array_push($arrayInfo, $dados[$i]->name);
            $departmentID = DB::table('professional_infos')->where('user_id', $userID)->value('department_id');
            $officeID = DB::table('office_deps')->where('iddepartments', $departmentID)->value('idoffice');
            $office = DB::table('offices')->where('id', $officeID)->value('description');
            array_push($arrayInfo, $office);
        }

        return view('testeEmployees')->with('dados',$arrayInfo);
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
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
