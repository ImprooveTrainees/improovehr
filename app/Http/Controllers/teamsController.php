<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\teams;
use App\teamUsers;
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

        $newTeam = new teams;
        $newTeam->officeID = $userLoggedIn->officeID(Auth::user()->id, Auth::user()->country);
        $newTeam->description = $teamName;
        $newTeam->save();

        $teamUser = new teamUsers;
        $teamUser->teamID = $newTeam->id;
        $teamUser->userID = $teamLeaderId;
        $teamUser->leader = true;
        $teamUser->save();


        

        

        $msg = "New team created successfully";
        
        return redirect()->action('UserController@employees')->with('message', $msg);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addTeamMember(Request $request)
    {
        // $usersSelected = $request->input('usersTeam');
        // $teamID = $request->input('teamID');
        // $lastSelectedOptionJS = "<script>document.getElementById('selectTeamID').value = ".$teamID.";</script>";

        // foreach($usersSelected as $userTeamAdd) {
        //     $newTeamUser = new teamUsers;
        //     $newTeamUser->teamID = $teamID;
        //     $newTeamUser->userID = $userTeamAdd;
        //     $newTeamUser->save();
        // }

        // return redirect()->action('UserController@employees')
        // ->with('message', 'Users added successfully');
        // ;


        //
        // $teamID = $request->input('teamDetailsId');

        // $selectedTeamMembers = teamUsers::where('teamID', $teamID)->get();

            
            $usersSelected = $request->input('usersTeam');
            $teamID = $request->input('teamID');
            $repeated = false;
            $leaderCheck = $request->input('leaderCheck');
            $allUsersTeam = teamUsers::where('teamID', $teamID)->get(); //todas as pessoas da equipa
            $msg = "";
            foreach($usersSelected as $user) {
                foreach($allUsersTeam as $teamUser) {
                    if($user == $teamUser->userID) {
                        $repeated = true;
                        break;
                    }
                }
            }
            if($repeated) {
                $msg .= "You cannot add repeated users to teams."; 
            }
            else {
                foreach($usersSelected as $userTeamAdd) {
                    $newTeamUser = new teamUsers;
                    $newTeamUser->teamID = $teamID;
                    $newTeamUser->userID = $userTeamAdd;
                    $newTeamUser->leader = $leaderCheck;
                    $newTeamUser->save();
                }
                $msg .= "Users added successfully."; 

            }
    
    


        return redirect()->action('UserController@employees')->with('message', $msg);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remTeamMember($idUserRem)
    {
        //
        $userToRemove = teamUsers::where('userID', $idUserRem);
        $userToRemove->delete();

        $msg = "User removed successfully from this team.";

        return redirect()->action('UserController@employees')->with('message', $msg);

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
