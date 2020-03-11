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

        $usersAttachments = DB::table('user_attachments')->where('idUser',$userLogin)->get();


        return view('testeProfessionalInfo')->with('users',$users)->with('profInfo',$profInfo)->with('usersAttachments',$usersAttachments);

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

        // return redirect('testeProfessionalInfo')->with('attachments',$attachments);

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
    public function edit(ProfessionalInfo $professionalInfo)
    {
        //
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
