<?php

namespace App\Http\Controllers;

use App\User;
use App\offices;
use App\departments;
use App\offices_deps;
use App\contract;
use App\users_deps;
use Hash;
use Auth;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use DB;
use Image;

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
            if($users[$i]->photo == null) {
                $msg .= "<td>No profile image</td>";
            }
            else {
                $msg .= "<td>"."<img class='sliderResize' src=".$users[$i]->photo."></td>";
            }
            $msg .= "<td>".$users[$i]->name."</td>";
            if($users[$i]->officeDescricao($users[$i]->id,$users[$i]->country) == null) {
                $msg .= "<td>Por definir</td>";
            }
            else {
                $msg .= "<td>".$users[$i]->officeDescricao($users[$i]->id,$users[$i]->country)."</td>";
            }//pôr office
            $msg .= "<td>".$users[$i]->contractUser->position."</td>";
            $depart = true;
            if($users[$i]->departments->first() == null) {
                $msg .= "<td>Por definir</td>";
                $depart = false;
            }
            else {
                $msg.= "<td>".$users[$i]->departments->first()->description."</td>";
            } //departamento
            $actualYear = date("Y/m/d");
            $date1=date_create($users[$i]->contractUser->start_date);
            $date2=date_create($actualYear);
            $diff=date_diff($date1,$date2);
            $tempoEmpresa = $diff->format("%Y%")." years";
            $msg .= "<td>".$tempoEmpresa."</td>";
            if(!$depart) {
                $msg.= "<td>Por definir</td>";
            }
            else if($users[$i]->name == $users[$i]->managerDoUser($users[$i]->departments->first()->description, $users[$i]->country)) {
                $msg .= "<td> ------- </td>";
            }
            else {
                $msg .= "<td>".$users[$i]->managerDoUser($users[$i]->departments->first()->description, $users[$i]->country)."</td>";
            }        
            $msg .= "</tr>";


        }

        $departmentList = departments::All();


        return view('employees')->with('msg', $msg)->with('departmentList', $departmentList);
    }

    public function newEmployeeView()
    {
        //
        return view('testeRegistoEmployee');
    }

    public function newEmployeeRegister(Request $request)
    {
        //
        $employee = new User();
        $contractNewEmployee = new contract();
        $userDepartment = new users_deps();
         
        $accountCreator = Auth::User();

        $name = $request->input('name');
        $email = $request->input('email');
        $passwordAutomatica = '12345678';
        if($request->input('otherRole') != null) {
            $role = $request->input('otherRole');
        }
        else {
            $role = $request->input('role');
        }      
        $country = $accountCreator->country;
        $dateNow = date("Y/m/d");
        $department = $request->input('Department');
        
        $employee->name = $name;
        $employee->email = $email;
        $employee->password = Hash::make($passwordAutomatica);
        $employee->country = $country;
        $employee->save();

        $contractNewEmployee->iduser = $employee->id;
        $contractNewEmployee->position = $role;
        $contractNewEmployee->start_date = $dateNow;
        $contractNewEmployee->save();

        $userDepartment->idDepartment = $department;
        $userDepartment->idUser = $employee->id;
        $userDepartment->save();

        return redirect()->action('UserController@employees')->with('message', 'Employee registered sucessfully');;



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
    public function storeProfileImg(Request $request)
    {
        //
        $idNome = Auth::User()->name;

        request()->validate([
            'fileUpload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);
       if ($files = $request->file('fileUpload')) {
        
           $image = $request->file('fileUpload');
           $resize_image = Image::make($image->getRealPath());

          

           $destinationPath = 'img/users'; // upload path
           $profileImage = strtolower($idNome). "." . $files->getClientOriginalExtension();

        //    $resize_image->resize(150, 100, function($constraint){
        //     $constraint->aspectRatio();
        //    })->save($destinationPath ."/".$profileImage); muda a resolução da imagem após upload

            $files->move($destinationPath, $profileImage);
           
        }
        $query = DB::table('users')
        ->where('id', Auth::User()->id)
        ->update(['photo' => 'img/users/'.$profileImage]);
        
        return Redirect::to("personal")
        ->withMessage('Profile image has been successfully changed.');
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
