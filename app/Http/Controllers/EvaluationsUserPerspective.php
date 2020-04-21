<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Survey;
use App\User;
use App\surveyUsers;
use Auth;
use DB;

class EvaluationsUserPerspective extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $authUser = Auth::User()->id;
        $surveyUserMsg = "";
        $surveyUser = User::find($authUser)->surveys()->get();
        
      
        $repeatedSurveys = [];
        foreach($surveyUser as $surveyName) {
            if(!in_array($surveyName->name, $repeatedSurveys)) {
                $dateLimit = surveyUsers::where('idSurvey',$surveyName->id)->where('idUser',$authUser)->first();
                $surveyUserMsg .= "<tr>";
                $surveyUserMsg .= "<td>".$surveyName->name."</td>";
                $surveyUserMsg .= "<td>".$surveyName->surveyType->description."</td>";

                $todayDate = date_create(date("Y/m/d"));
                $Limit = date_create($dateLimit->dateLimit);
                $interval = date_diff($todayDate, $Limit); 

                $surveyUserMsg .= "<td>".$interval->format('%d days left')."</td>";
                $surveyUserMsg .= "</tr>";
                array_push($repeatedSurveys,$surveyName->name);
            }
            
        }
        
    


        return view('testeEvalsUserPerspectiveIndex')->with('surveyUserMsg',$surveyUserMsg);
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
