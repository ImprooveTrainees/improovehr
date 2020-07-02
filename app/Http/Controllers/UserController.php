<?php

namespace App\Http\Controllers;

use App\User;
use App\offices;
use App\departments;
use App\offices_deps;
use App\contract;
use App\users_deps;
use App\contractType;
use App\teams;
use App\teamUsers;
use App\Record_users;
use Hash;
use Auth;
use Illuminate\Http\Request;
use App\notifications;
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

        return view('personal_info')
        ->with('users', $users)
        ->with('age', $age)
        ->with('statusArray', $statusArray)
        ->with('statusAcademic', $statusAcademic)
        ;
    }

    public function employees(Request $request)
    {
        //
        //$idAutenticado = Auth::User()->id;

        $managerListNames = [];
        $managerListIDs = [];
        $userLeaders = User::All();
        $userLoggedIn = Auth::user();

        $allTeams = teams::All();


        $users = User::all();
        $departments = departments::all();
        $userLogged = Auth::user();

        $contractTypes = contractType::All();


        $msg = "";
        // $actualYear = date("Y/m/d");
        // $date1=date_create($users->birthDate);
        // $date2=date_create($actualYear);
        // $diff=date_diff($date1,$date2);
        // $age = $diff->format("%Y%"); //formato anos
        for($i = 0; $i < count($users); $i++) {
            if($userLogged->country == $users[$i]->country) { //só users do office do user logado
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
            if($userLogged->idusertype == 1) { // se for admin
                    $msg .= "<td>"."<button onclick='modalOpen(".$users[$i]->id.")' value=".$users[$i]->id."><i class='fas fa-user-edit'></i></button>"."</td>";
                    $msg .= "<td>"."<a onclick='return confirmDelete()' href='/deleteEmployee/".$users[$i]->id."'><i class='fas fa-user-slash'></i></a>"."</td>";

            }
            else if($userLogged->idusertype == 2) { // se for manager
                if($users[$i]->idusertype != 1) {
                    $msg .= "<td>"."<button onclick='modalOpen(".$users[$i]->id.")' value=".$users[$i]->id."><i class='fas fa-user-edit'></i></button>"."</td>";
                    $msg .= "<td>"."<a onclick='return confirmDelete()' href='/deleteEmployee/".$users[$i]->id."'><i class='fas fa-user-slash'></i></a>"."</td>";
                }
            }
            else if($userLogged->idusertype == 3) { // se for RH
                if($users[$i]->idusertype != 1 && $users[$i]->idusertype != 2) {
                    $msg .= "<td>"."<button onclick='modalOpen(".$users[$i]->id.")' value=".$users[$i]->id."><i class='fas fa-user-edit'></i></button>"."</td>";
                    $msg .= "<td>"."<a onclick='return confirmDelete()' href='/deleteEmployee/".$users[$i]->id."'><i class='fas fa-user-slash'></i></a>"."</td>";
                }
            }
            $msg .= "</tr>";
            }



        }

        $departmentList = departments::All();

        //Teams
            $teamDetailsId = $request->input('teamDetailsId');
            if(isset($teamDetailsId)){ //caso a variavel esteja definida, é porque foi executada a form

            $selectedTeamMembers = teamUsers::where('teamID', $teamDetailsId)->get();
            $selectedTeamMembersArray = [];
            $leaderArray = [];
            $teamID = teamUsers::where('teamID', $teamDetailsId)->first()->teamID;
            $teamName = teams::find($teamID)->description;
            foreach($selectedTeamMembers as $selectedMember) {
                $user = User::find($selectedMember->userID);
                array_push($selectedTeamMembersArray, $user);
                if($selectedMember->leader == true) { //vê se o user é lider
                    array_push($leaderArray, "Yes");
                }
                else {
                    array_push($leaderArray, "No");
                }
            }


            $LoggedUserTeams = teamUsers::where('userID', $userLogged->id)->get(); //todas as equipas a que o user pertence
            $LoggedUserTeamsArrayUserId = [];
            $LoggedUserTeamsArrayTeamId = [];
            $LoggedUserTeamsArrayTeamName = [];
            $LoggedUserTeamsArrayTeamLeaders = [];
            $tablesCount = teamUsers::where('userID', $userLogged->id)->get();

            foreach($LoggedUserTeams as $teamUserId) {
                array_push($LoggedUserTeamsArrayTeamName,teams::find($teamUserId->teamID));
                $teamMembersTeam = teamUsers::where('teamID', $teamUserId->teamID)->get();
                foreach($teamMembersTeam as $teamMember) {
                    array_push($LoggedUserTeamsArrayUserId,User::find($teamMember->userID));
                    array_push($LoggedUserTeamsArrayTeamId,teams::find($teamUserId->teamID));
                    if($teamMember->leader == true) { //vê se o user é lider
                        array_push($LoggedUserTeamsArrayTeamLeaders, "Yes");
                    }
                    else {
                        array_push($LoggedUserTeamsArrayTeamLeaders, "No");
                    }

                }


            }


            return view('employees') //manda as vars da form para a mesma pag
            ->with('msg', $msg)
            ->with('departmentList', $departmentList)
            ->with('userLogged', $userLogged)
            ->with('contractTypes', $contractTypes)
            ->with('departments', $departments)
            ->with('userLeaders', $userLeaders)
            ->with('allTeams', $allTeams)
            ->with('selectedTeamMembersArray', $selectedTeamMembersArray)
            ->with('teamDetailsId', $teamDetailsId)
            ->with('users', $users)
            ->with('leaderArray', $leaderArray)
            ->with('teamName', $teamName)
            ->with('LoggedUserTeamsArrayUserId',$LoggedUserTeamsArrayUserId)
            ->with('LoggedUserTeamsArrayTeamId', $LoggedUserTeamsArrayTeamId)
            ->with('tablesCount', $tablesCount)
            ->with('LoggedUserTeamsArrayTeamName', $LoggedUserTeamsArrayTeamName)
            ->with('LoggedUserTeamsArrayTeamLeaders', $LoggedUserTeamsArrayTeamLeaders)
            ;

        }

        $LoggedUserTeams = teamUsers::where('userID', $userLogged->id)->get(); //todas as equipas a que o user pertence
        $LoggedUserTeamsArrayUserId = [];
        $LoggedUserTeamsArrayTeamId = [];
        $LoggedUserTeamsArrayTeamName = [];
        $LoggedUserTeamsArrayTeamLeaders = [];
        $tablesCount = teamUsers::where('userID', $userLogged->id)->get();

        foreach($LoggedUserTeams as $teamUserId) {
            array_push($LoggedUserTeamsArrayTeamName,teams::find($teamUserId->teamID));
            $teamMembersTeam = teamUsers::where('teamID', $teamUserId->teamID)->get();
            foreach($teamMembersTeam as $teamMember) {
                array_push($LoggedUserTeamsArrayUserId,User::find($teamMember->userID));
                array_push($LoggedUserTeamsArrayTeamId,teams::find($teamUserId->teamID));
                if($teamMember->leader == true) { //vê se o user é lider
                    array_push($LoggedUserTeamsArrayTeamLeaders, "Yes");
                }
                else {
                    array_push($LoggedUserTeamsArrayTeamLeaders, "No");
                }
            }


        }


        //End Teams


        return view('employees')
        ->with('msg', $msg)
        ->with('departmentList', $departmentList)
        ->with('userLogged', $userLogged)
        ->with('contractTypes', $contractTypes)
        ->with('departments', $departments)
        ->with('userLeaders', $userLeaders)
        ->with('allTeams', $allTeams)
        ->with('LoggedUserTeamsArrayUserId',$LoggedUserTeamsArrayUserId)
        ->with('LoggedUserTeamsArrayTeamId',$LoggedUserTeamsArrayTeamId)
        ->with('tablesCount', $tablesCount)
        ->with('LoggedUserTeamsArrayTeamName', $LoggedUserTeamsArrayTeamName)
        ->with('LoggedUserTeamsArrayTeamLeaders', $LoggedUserTeamsArrayTeamLeaders)
        ;
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

        $idusertype = 4;

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

        //ID USER TYPE

        if($role == "Manager") {

            $idusertype = 2;

        } else if($role == "Human Resources") {

            $idusertype = 3;

        }

        $country = $accountCreator->country;
        $dateNow = date("Y/m/d");
        $department = $request->input('Department');
        $officeAdressCreator = $accountCreator->officeAdress; // caso haja mais offices no país

        $employee->name = $name;
        $employee->email = $email;
        $employee->password = Hash::make($passwordAutomatica);
        $employee->country = $country;
        $employee->officeAdress = $officeAdressCreator;
        $employee->idusertype = $idusertype;
        $employee->save();

        $contractNewEmployee->iduser = $employee->id;
        $contractNewEmployee->position = $role;
        $contractNewEmployee->start_date = $dateNow;
        $contractNewEmployee->save();

        $userDepartment->idDepartment = $department;
        $userDepartment->idUser = $employee->id;
        $userDepartment->save();

        // $newNotification = new notifications; //guarda o aniv nas notificações
        // $newNotification->userID = $employee->id;
        // $newNotification->read = false;
        // $newNotification->notificationType = "Birthday";
        // $newNotification->save();


        return redirect()->action('UserController@employees')->with('message', 'Employee registered sucessfully');



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
        $id_user= Auth::user()->id;

        $passUserAuth = DB::table('users')
        ->where('users.id','=',$id_user)
        ->select('users.password')->value('password');

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

        $currentPass = $request->input('currentPass');
        $newPass = $request->input('newPass');

        $userLogado = User::find(Auth::User()->id);

        $isPasswordValid = false;

        if($currentPass !== null || $newPass !== null) {

            if (Hash::check($currentPass, $passUserAuth) || $currentPass == $passUserAuth) {

                if($currentPass !== null) {

                    $isPasswordValid = true;

                }


            }

            if($currentPass == $newPass && ($currentPass!==null && $newPass!==null)) {

                $msgPass = "Error! The Passwords are the same. Try Again.";

                return redirect()->action('UserController@index')->with('message', $msgPass);

            }

            if($isPasswordValid == true) {

                if($newPass !== null) {

                    $userLogado->password = Hash::make($newPass);

                } else {

                    $msgPass = "Error! New Password is empty. Try Again.";

                    return redirect()->action('UserController@index')->with('message', $msgPass);

                }

            } else {

                $msgPass = "Error! Current Password is incorrect. Try Again.";

                return redirect()->action('UserController@index')->with('message', $msgPass);

            }


        }

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


        // $notification = notifications::where('userID',Auth::User()->id)->where('notificationType', 'Birthday')->first();  //edita o aniv nas notificações
        // if($notification != null) {
        //     $notification->dateBegin = $birthday;
        //     $notification->dateEnd = $birthday;
        //     $notification->save();
        // }





        return redirect()->action('UserController@index')->with('message', 'Info saved successfully');




    }

    public function editProfessionalInfo(Request $request)
    {
        //
        $userId = $request->input('idUser');
        $newRole = $request->input('roleEditProf');
        $contractTypeId = $request->input('contractTypeEdit');
        $departmentId = $request->input('departmentTypeEdit');
        $contractBegin = $request->input('dateBeginEditProf');
        $contractEnd = $request->input('dateEndEditProf');
        $companyMail = $request->input('companyMailProfInfo');
        $companyMobile = $request->input('companyMobileProfInfo');

        $editContractUser = contract::where('iduser', $userId)->first();
        $editContractUser->position = $newRole;
        $editContractUser->idcontracttype = $contractTypeId;

        $editContractUser->start_date = $contractBegin;
        $editContractUser->end_date = $contractEnd;
        $editContractUser->save();

        $userDep = users_deps::where('idUser', $userId)->first();
        $userDep->idDepartment = $departmentId;
        $userDep->save();

        $userSelected = User::find($userId);

        //ID USER TYPE

        if($newRole == "Manager") {

            $idusertype = 2;

        } else if($newRole == "Human Resources") {

            $idusertype = 3;

        } else {

            $idusertype = 4;

        }

        $userSelected->idusertype = $idusertype;
        $userSelected->compMail = $companyMail;
        $userSelected->compPhone = $companyMobile;
        $userSelected->save();


        return redirect()->action('UserController@employees')->with('message', 'Info saved successfully');

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
    public function deleteEmployee($id)
    {
        //
        $userToRemove = User::find($id);

        // ADD ELIMINATED USER TO RECORDS TABLE

        $user_to_records = new Record_users();

        $user_to_records->userid=$id;
        $user_to_records->name=$userToRemove->name;
        $user_to_records->email=$userToRemove->email;
        $user_to_records->password=$userToRemove->password;
        $user_to_records->idusertype=$userToRemove->idusertype;
        $user_to_records->iddepartment=$userToRemove->iddepartment;
        $user_to_records->idcontract=$userToRemove->idcontract;
        $user_to_records->address=$userToRemove->address;
        $user_to_records->academicQual=$userToRemove->academicQual;
        $user_to_records->phone=$userToRemove->phone;
        $user_to_records->photo=$userToRemove->photo;
        $user_to_records->birthDate=$userToRemove->birthDate;
        $user_to_records->status=$userToRemove->status;
        $user_to_records->taxNumber=$userToRemove->taxNumber;
        $user_to_records->IBAN=$userToRemove->IBAN;
        $user_to_records->sosContact=$userToRemove->sosContact;
        $user_to_records->sosRelationship=$userToRemove->sosRelationship;
        $user_to_records->sosName=$userToRemove->sosName;
        $user_to_records->country=$userToRemove->country;

        $user_to_records->save();

        // END - ADD ELIMINATED USER TO RECORDS TABLE

        $userToRemove->delete();

        $msg = "Employee removed succesfully";

        return redirect()->action('UserController@employees')->with('message', $msg);





    }
}
