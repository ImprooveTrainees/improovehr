<?php

namespace App\Http\Controllers;

use App\User;
use App\offices;
use App\departments;
use App\offices_deps;
use Illuminate\Http\Request;


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
        $idAutenticado = Auth::User()->id;
        $users = User::where('id', $idAutenticado)->first();
        $actualYear = date("Y/m/d");       
        $date1=date_create($users->birthDate);
        $date2=date_create($actualYear);
        $diff=date_diff($date1,$date2);
        $age = $diff->format("%Y%"); //formato anos

        return view('testePersonalInfo')->with('users', $users)->with('age', $age);
    }

    public function employees()
    {
        //
        //$idAutenticado = Auth::User()->id;
        $users = User::all();
        $departments = departments::all();


        $msg = "";
        // $actualYear = date("Y/m/d");       
        // $date1=date_create($users->birthDate);
        // $date2=date_create($actualYear);
        // $diff=date_diff($date1,$date2);
        // $age = $diff->format("%Y%"); //formato anos
        for($i = 0; $i < count($users); $i++) {
            $msg .= "<tr>";
            $msg .= "<td>".$users[$i]->photo."</td>";
            $msg .= "<td>".$users[$i]->name."</td>";
            $msg .= "<td>".$users[$i]->officeDescricao($users[$i]->id)->first()->description."</td>"; //pôr office
            $msg .= "<td>".$users[$i]->contractUser->position."</td>";
            $msg .= "<td>".$users[$i]->departments->first()->description."</td>"; //departamento
            $actualYear = date("Y/m/d");       
            $date1=date_create($users[$i]->contractUser->start_date);
            $date2=date_create($actualYear);
            $diff=date_diff($date1,$date2);
            $tempoEmpresa = $diff->format("%Y%")." years";
            $msg .= "<td>".$tempoEmpresa."</td>";
            $msg .= "</tr>";


        }
        
        

        return view('testeEmployees')->with('msg', $msg);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
