<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Survey;
use App\User;
use App\surveyUsers;
use App\Areas;
use App\subCategories;
use App\Questions;
use App\PP;
use App\typeQuestion;
use App\surveyType;
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
        if($surveyUser->count() == 0) {
            $surveyUserMsg .= "There are no available surveys at the moment.";
        }
        else {
                  
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

                $surveyUserMsg .= "<td>".$interval->format('%d days left')."(".$Limit->format('d-m-Y').")</td>";
                $surveyUserMsg .= "<td><a href=showSurveyUser/".$surveyName->id."><i class='fas fa-pencil-alt'></i></a></td>";
                //chama a route com o nome "showSurveyUser", e passa o argumento do nr do survey
                $surveyUserMsg .= "</tr>";
                array_push($repeatedSurveys,$surveyName->name);
            }
            
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
    public function showSurvey($id)
    {
        //
        $selectedSurveyId = $id;


        $surveyName = Survey::find($selectedSurveyId)->name;
        $surveyType = Survey::find($selectedSurveyId)->surveyType->description;
        $allAreasDB = Areas::All();
        $subCats = subCategories::All();
        $PPs = PP::All();
        $users = User::All();
        $questionTypes = typeQuestion::All();
        $surveyAreas = Survey::find($selectedSurveyId)->areas()->get();
        $countQuestions = 1;
        $surveyTypes = surveyType::All();
        $surveys = Survey::All();

        $areasExist = false;
        $areasHTML = [];
        $subCatsHTML = [];
        $questionsNumericHTML = [];
        $openQuestionsHTML = [];
        $usersEvaluatedHTML = [];
        $usersWillEvalueHTML = [];

            for($i = 0; $i < $surveyAreas->count(); $i++){
                array_push($areasHTML,$surveyAreas[$i]);
                $subCats = Areas::find($surveyAreas[$i]->id)->subCategories()->get();
                if($subCats->count() == 0) {
                    array_push($subCatsHTML,$surveyAreas[$i],'0');
                }
                else {
                    foreach($subCats as $subcatArea) {
                            array_push($subCatsHTML,$surveyAreas[$i],$subcatArea);       
                            $subCatsQuestions = subCategories::find($subcatArea->id)->questions()->orderBy('created_at', 'asc')->get();
                            if($subCatsQuestions->count() == 0) {
                                array_push($questionsNumericHTML,$subcatArea,'0');
                            }
                            else {
                            foreach($subCatsQuestions as $question) {
                                if($question->idTypeQuestion == 2) {
                                    array_push($questionsNumericHTML,$subcatArea, $question);                                 
                                } //mostra apenas as questões numéricas, e não as abertas, pois estas não
                                  //têm subcategoria
                                
                            }
                        }
                    }
                }       
            }
            foreach($surveyAreas as $sAreasOpen) {
                    $openQuestions = Areas::find($sAreasOpen->id)->openQuestions()->orderBy('created_at', 'asc')->get();
                    if($openQuestions->count() == 0) {
                        array_push($openQuestionsHTML,$sAreasOpen,'0');
                    }
                    else {
                        foreach($openQuestions as $openQuestion) {
                            array_push($openQuestionsHTML,$sAreasOpen,$openQuestion);
                        }
                    }
                        
                    
            } //aqui procura só as questoes abertas, que não têm subcategoria
        
        //Users assigned
            $usersEvaluated = surveyUsers::where('idSurvey', $selectedSurveyId)->get();
            foreach($usersEvaluated as $user) {            
                if($user->evaluated == 1) {
                    array_push($usersEvaluatedHTML,User::find($user->idUser)->name);
                }
                else {
                    $usersWillEvalueHTML[User::find($user->idUser)->name] = User::find($user->willEvaluate)->name;
                }
                
            }    


        //End Survey Structure


    return view('testeEvalsUserPerspectiveBeginSurvey')->with(compact('surveyTypes', 'surveys',
    'surveyName','surveyType', 
    'selectedSurveyId', 'allAreasDB','surveyAreas', 
    'questionTypes', 'PPs',
    'users',
    'usersEvaluated',
    'areasHTML',
    'subCatsHTML',
    'openQuestionsHTML',
    'questionsNumericHTML',
    'usersEvaluatedHTML',
    'usersWillEvalueHTML',
    ));


            //End Survey Structure

        


        return view('testeEvalsUserPerspectiveBeginSurvey')->with('showSurveyGeneral', $showSurveyGeneral);
    }

    public function avgPPArea(Request $request)
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
