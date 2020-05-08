<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;

class EvaluationsResults extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $surveyNames = [];
        $userNames = [];
        $surveyType = [];
        $surveys = Survey::All();

        for($i = 0; $i < $surveys->count(); $i++){
             $usersSurvey = Survey::find($surveys[$i]->id)->users()->get();
             foreach($usersSurvey as $user) {
                 array_push($surveyNames, $surveys->name);
                 array_push($userNames, $user->name);
                 array_push($surveyType, $surveys[$i]->idSurveyType);
             }
        } 


        return view('testeEvalsResultsIndex');
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
