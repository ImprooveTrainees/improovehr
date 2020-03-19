<?php

namespace App\Http\Controllers;

use App\ProfessionalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\contract;
use App\UserAttachments;

class ProfessionalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userLogin = Auth::User()->id;
        $users = User::where('id', $userLogin)->get();
        $profInfo = DB::table('users')
                                ->join('contracts', 'users.id','=','contracts.iduser')
                                ->join('contract_types', 'contract_types.id','=','contracts.idcontracttype')
                                ->join('users_deps', 'users.id','=','users_deps.idUser')
                                ->join('departments', 'departments.id','=','users_deps.idDepartment')
                                ->select('*', 'contract_types.description AS contracType')
                                ->where('users.id','=',$userLogin)
                                ->get();

        $userLoginDep= DB::table('users_deps')
                                    ->where('users_deps.iduser',$userLogin)->value('idDepartment');
        $userCountry = DB::table('users')
                                    ->where('users.id',$userLogin)->value('country');

        $manager = DB::table('users')
                                    ->join('users_deps', 'users.id', '=', 'users_deps.idUser')
                                    ->join('departments', 'users_deps.idDepartment', '=', 'departments.id')
                                    ->join('contracts', 'contracts.iduser', '=', 'users.id')
                                    ->join('offices_deps','offices_deps.idDepartment','=','departments.id')
                                    ->join('offices','offices.id','=','offices_deps.idOffice')
                                    ->where('contracts.position','=', 'Manager')
                                    ->where('offices.country','=',$userCountry)
                                    ->where('users.country','=',$userCountry)
                                    ->where('users_deps.idDepartment','=', $userLoginDep)
                                    ->select('users.name as Manager')
                                    ->get();

                                    // select users.name
                                    // from  users, departments, users_deps,contracts
                                    // where users.id=users_deps.idUser
                                    // and users_deps.idDepartment=departments.id
                                    // and contracts.iduser=users.id
                                    // and contracts.position="Manager"
                                    // and users_deps.idDepartment
                                    // in(
                                    // select users_deps.idDepartment from users,users_deps where users_deps.iduser =3);

        $usersAttachments = DB::table('user_attachments')->where('idUser',$userLogin)->get();

        return view('professional_info')->with('users',$users)->with('profInfo',$profInfo)->with('usersAttachments',$usersAttachments)->with('manager',$manager)->with('userCountry',$userCountry);

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
    public function store(Request $req)
    {

        $attachments = new UserAttachments();
        $userLogin = Auth::User()->id;


        $attachments->idUser=$userLogin;
        $attachments->files=request('user_img');

        $attachments->save();

        return redirect()->action('ProfessionalInfoController@index')->with('file', 'Document added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProfessionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function show(ProfessionalInfo $professionalInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProfessionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $compPhone = $request->input('compPhone');
        $compMail = $request->input('compMail');

        $userLogin = User::find(Auth::User()->id);

        $userLogin->compPhone = $compPhone;
        $userLogin->compMail = $compMail;

        $userLogin->save();

        return redirect()->action('ProfessionalInfoController@index')->with('pop', 'Info updated successfully');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProfessionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfessionalInfo $professionalInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProfessionalInfo  $professionalInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfessionalInfo $professionalInfo)
    {
        //
    }
}
