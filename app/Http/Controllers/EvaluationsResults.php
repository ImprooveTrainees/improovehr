<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\surveyUsers;

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
        $surveyNames = []; //surveys
        $userNames = []; //users
        $surveyType = []; //types
        $surveys = Survey::All();
        $submitted = 0;
        $total = 0;

        for($i = 0; $i < $surveys->count(); $i++){
             $usersSurvey = Survey::find($surveys[$i]->id)->users()->get(); //todos os users deste survey (iteração)
             for($b = 0; $b < $usersSurvey->count(); $b++) {
                $isSubmitted = surveyUsers::where('idSurvey', $surveys[$i]->id)->where('idUser', $usersSurvey[$b]->id)->first()->submitted;
                if($isSubmitted == 1) { //mostra apenas o questionarios já submetidos
                    array_push($surveyNames, $surveys[$i]);
                    array_push($userNames, $usersSurvey[$b]);
                    array_push($surveyType, $surveys[$i]->surveyType()->first());
                    $submitted++;
                    $total++;    
                }
                else {
                    $total++;
                }

             }
        } 
        //ele procura todos os surveys e todos os users que lhe pertencem

        return view('testeEvalsResultsIndex')
        ->with('surveyNames',$surveyNames)
        ->with('userNames',$userNames)
        ->with('surveyType',$surveyType)
        ->with('submitted',$submitted)
        ->with('total',$total)
        ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResults()
    {
        //
        return view('testeEvalsShowResults');
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
