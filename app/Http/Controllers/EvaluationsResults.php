<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Survey;
use App\surveyUsers;
use App\Answers;
use App\questSurvey;

use App\Areas;
use App\subCategories;
use App\PP;
use App\User;
use App\typeQuestion;
use App\surveyType;

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
    public function showResults($idSurvey, $idUser)
    {
        //
        $idAnswersUser = Answers::where('idUser', $idUser)->get();
        $idQuestSurveys = questSurvey::All();
        $arrayQuestSurvey = [];
        $answersUserSurvey = [];

        foreach($idQuestSurveys as $questSurvey) {
            foreach($idAnswersUser as $answer) {
                if($questSurvey->id == $answer->idQuestSurvey && $questSurvey->idSurvey == $idSurvey) {
                    array_push($arrayQuestSurvey, $questSurvey); //se o id questSurvey(table com questões ligadas ao survey) for igual ao que está nas respostas, assim como o surveyId, é a resposta do user relativo
                    array_push($answersUserSurvey, $answer); //guarda as respostas
                }
            }
        }


    //    foreach($answersUserSurvey as $answerGiven) {
    //        echo $answerGiven->value."<br>";
    //    }
//survey structure


        $selectedSurveyId = $idSurvey;

        $userSelected = User::find($idUser);
        $willEvaluateUser = surveyUsers::where('idUser', $idUser)->where('idSurvey', $selectedSurveyId)->first()->willEvaluate;
        $willEvaluateNameUser = User::find($willEvaluateUser)->name;

        $surveyTypes = surveyType::All();
        $surveys = Survey::All();
        $surveyName = Survey::find($selectedSurveyId)->name;
        $surveyType = Survey::find($selectedSurveyId)->surveyType;
        $surveyAnswerLimit = Survey::find($selectedSurveyId)->answerLimit;
        $surveyAreas = Survey::find($selectedSurveyId)->areas()->get();

        $allAreasDB = Areas::All();
        $subCats = subCategories::All();
        $PPs = PP::All();
        $users = User::All();
        $questionTypes = typeQuestion::All();
        $countQuestions = 1;


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
        
        // //Users assigned
        //     $usersEvaluated = surveyUsers::where('idSurvey', $selectedSurveyId)->get();
        //     foreach($usersEvaluated as $user) {            
        //         if($user->evaluated == 1) {
        //             array_push($usersEvaluatedHTML,User::find($user->idUser)->name);
        //         }
        //         else {
        //             $usersWillEvalueHTML[User::find($user->idUser)->name] = User::find($user->willEvaluate)->name;
        //         }
                
        //     }
            
//end survey structure


        return view('testeEvalsShowResults')
        ->with('areasHTML', $areasHTML)
        ->with('subCatsHTML', $subCatsHTML)
        ->with('questionsNumericHTML', $questionsNumericHTML)
        ->with('openQuestionsHTML', $openQuestionsHTML)
        ->with('usersEvaluatedHTML', $usersEvaluatedHTML)
        ->with('usersWillEvalueHTML', $usersWillEvalueHTML)
        ->with('surveyAreas',$surveyAreas)
        ->with('selectedSurveyId', $selectedSurveyId)
        ->with('surveyAnswerLimit', $surveyAnswerLimit)
        ->with('surveyName',  $surveyName)
        ->with('surveyType', $surveyType)
        ->with('userSelected', $userSelected)
        ->with('willEvaluateNameUser', $willEvaluateNameUser)
        ->with('surveyAnswerLimit', $surveyAnswerLimit)
        ->with('arrayQuestSurvey', $arrayQuestSurvey)
        ->with('answersUserSurvey', $answersUserSurvey)
        ;
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
