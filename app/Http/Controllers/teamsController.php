<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\teams;
use App\team_users;
use Auth;

class teamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $userLoggedIn = Auth::user();
        $teamName = $request->input('teamName');
        $teamLeaderId = $request->input('teamLeader');
        $teamName = $request->input('teamName');

        $newTeam = new teams;
        $newTeam->officeID = $userLoggedIn->officeID(Auth::user()->id, Auth::user()->country);
        $newTeam->userIDLeader = $request->input('teamLeader');
        $newTeam->description = $teamName;

        

        $newTeam->save();

        $msg = "New team created successfully";
        
        return redirect()->action('UserController@employees')->with('message', $msg);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showTeamDetails(Request $request)
    {
        //
        $teamID = $request->input('teamDetailsId');
        

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
