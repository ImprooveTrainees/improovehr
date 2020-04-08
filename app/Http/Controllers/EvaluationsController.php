<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\surveyType;
use App\Survey;
use App\Areas;

class EvaluationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $surveyTypes = surveyType::All();
        $areas = Areas::All();
        $surveys = Survey::All();


        return view('testeCreateEvals')->with('surveyTypes', $surveyTypes)->with('areas', $areas)
        ->with('surveys', $surveys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createSurvey(Request $request)
    {
        //
        $survey = new Survey;

        $surveyName = $request->input('surveyName');
        $answLimit = $request->input('answerLimit');
        $surveyType = $request->input('surveyType');

        $survey->name = $surveyName;
        $survey->answerLimit = $answLimit;
        $survey->idSurveyType = $surveyType;

        $survey->save();


        return redirect()->action('EvaluationsController@index');
    }

    public function createArea(Request $request)
    {
        //
        $areas = new Areas;

        $areaName = $request->input('newArea');

        $areas->description = $areaName;
        $areas->save();


        return redirect()->action('EvaluationsController@index');
    }


    public function createQuestion(Request $request)
    {
        //
       

        return redirect()->action('EvaluationsController@index');
    }

    
    public function showAreasSurvey(Request $request)
    {
        //
        $idSurveySelected = $request->input('idSurvey');
        $areasInSurvey = Survey::find($idSurveySelected)->areas()->get();
        $surveyName = Survey::find($idSurveySelected)->name;
        $areasInSurveyMsg = "Areas in <strong>".$surveyName.":</strong> <br>";
        foreach($areasInSurvey as $areas) {
            $areasInSurveyMsg .= $areas->description."<br>";

        }

        
        return redirect()->action('EvaluationsController@index')
        ->with('areasPerSurvey', $areasInSurveyMsg);
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
