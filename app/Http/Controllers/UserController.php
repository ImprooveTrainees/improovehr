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
        //$arrayInfo = [];
        $msg = "";
        for($i = 0; $i < count($dados); $i++) {
            $userID = $dados[$i]->id;
            // array_push($arrayInfo, "foto");
            // array_push($arrayInfo, $dados[$i]->name);
            $departmentID = DB::table('professional_infos')->where('user_id', $userID)->value('department_id');
            $officeID = DB::table('office_deps')->where('iddepartments', $departmentID)->value('idoffice');
            $office = DB::table('offices')->where('id', $officeID)->value('description');
            // array_push($arrayInfo, $office);
            $contractID = DB::table('professional_infos')->where('user_id', $userID)->value('contract_id');
            $role = DB::table('contracts')->where('id', $contractID)->value('position');
            // array_push($arrayInfo, $role);
            $dataFimColabDB=DB::table('contracts')->where('id', $contractID)->value('start_date');    
            $actualYear = date("Y/m/d");       
            $date1=date_create($dataFimColabDB);
            $date2=date_create($actualYear);
            $diff=date_diff($date1,$date2);
            $tempoNaEmpresa = $diff->format("%Y%"); //formato anos
            // array_push($arrayInfo, $tempoNaEmpresa);
            $idManager = DB::table('departments')->where('id', $departmentID)->value('idManager');
            $manager = DB::table('users')->where('id', $idManager)->value('name');
            $pic = DB::table('personal_infos')->where('user_id', $userID)->value('photo');

            // array_push($arrayInfo, $manager);
            $msg .= "<tr>
            <td>".$pic."</td>
            <td>".$dados[$i]->name."</td>
            <td>".$office."</td>
            <td>".$role."</td>
            <td>".$tempoNaEmpresa."</td>
            <td>".$manager."</td>
            </tr>";
        }

        return view('testeEmployees')->with('msg',$msg);
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
