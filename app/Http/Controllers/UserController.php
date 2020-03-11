<?php

namespace App\Http\Controllers;

use App\User;
use App\offices;
use App\departments;
use App\offices_deps;
use Auth;
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
        $statusArray = ['Married', 'Single', 'Other'];
        $statusAcademic = ['Doctorate', 'Masters', 'Graduate', 'High School', 'Middle School', 'Elementary School'];

        return view('personal_info')->with('users', $users)->with('age', $age)->with('statusArray', $statusArray)->with('statusAcademic', $statusAcademic);
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
            $msg .= "<td>".$users[$i]->managerDoUser($users[$i]->id)->first()->name."</td>";
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
    public function edit(Request $request)
    {
        //

        $name = $request->input('name');
        $status = $request->input('status');
        $academic = $request->input('academic');
        $birthday = $request->input('birthday');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        $nif = $request->input('nif');
        $address = $request->input('address');
        $city = $request->input('city');
        $zip = $request->input('zip');
        $sosName = $request->input('sosName');
        $sosContact = $request->input('sosContact');
        $iban = $request->input('iban');
        $linkedIn = $request->input('linkedIn');


        $userLogado = User::find(Auth::User()->id);

        $userLogado->name = $name;
        $userLogado->status = $status;
        $userLogado->academicQual = $academic;
        $userLogado->birthDate = $birthday;
        $userLogado->phone = $mobile;
        $userLogado->email = $email;
        $userLogado->taxNumber = $nif;
        $userLogado->address = $address;
        $userLogado->city = $city;
        $userLogado->zip_code = $zip;
        $userLogado->sosName = $sosName;
        $userLogado->sosContact = $sosContact;
        $userLogado->iban = $iban;
        $userLogado->linkedIn = $linkedIn;


        $userLogado->save();

        return redirect()->action('UserController@index')->with('message', 'Info saved successfully');;




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
