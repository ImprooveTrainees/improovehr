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
use App\Questions;

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

        $questionsClosedForPercentage = [];

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
                                    array_push($questionsClosedForPercentage, $question);                                   
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
        
//end survey structure

        $idAnswersUser = Answers::where('idUser', $idUser)->get();
        $idQuestSurveys = questSurvey::All();
        $arrayQuestSurvey = []; //all questions in survey
        $answersUserSurvey = []; //all answers in survey



        foreach($idQuestSurveys as $questSurvey) {
            foreach($idAnswersUser as $answer) {
                if($questSurvey->id == $answer->idQuestSurvey && $questSurvey->idSurvey == $idSurvey) {
                    array_push($arrayQuestSurvey, $questSurvey); //se o id questSurvey(table com todas as questões ligadas ao survey) for igual ao que está nas respostas, assim como o surveyId, é a resposta do user relativo
                    array_push($answersUserSurvey, $answer); //guarda as respostas (todas)           
            
                }
            }
        }

        $totalPercentagePerformanceFinal = [];
        $totalPercentagePotentialFinal = [];
        $totalNoPercentagePerformancePotential = [];


        $totalPercentageFinalAll = [];

        $totalPercentagesAllQuestions = [];
        $totalAllQuestions = [];

        foreach($surveyAreas as $area) {
            $questionsThisAreaWeight = []; //peso por questão da area
            $questionsThisAreaPercentagePerQuestion = []; //percentagem(weight) por questao
            $questionsThisAreaWeightedScore = []; //weightedScore por questao (calculo: Resposta / RatingScale * Percentage(weight))
            $answersThisAreaScore = []; //resposta de cada pergunta
            $totalWeights = 0; //irá somar todos os pesos (não percentagens)

            $totalPercentagesSum = 0; //total percentagens somado
            $totalWeightedScoreSum = 0; //total weighted score somado

            $questionsThisAreaType = []; //performance ou potencial
            $totalWeightsPerformance = 0;
            $totalWeightsPotential = 0;
            $totalPercentagesSumPerformance = 0;
            $totalPercentagesSumPotential = 0;
            $totalWeightedScorePerformanceSum = 0;
            $totalWeightedScorePotentialSum = 0;
            $questionsThisAreaPerformancePotentialPercentagePerQuestion = [];


            foreach($questionsClosedForPercentage as $question) {
                $subCatId = $question->idSubcat;
                $areaQuestionId = subCategories::find($subCatId);
                if($area->id == $areaQuestionId->idArea) { //se a area actual for igual a area da questao
                    $weight = $question->weight;
                    array_push($questionsThisAreaWeight, $weight);
                    array_push($totalAllQuestions, $question); //põe a questão na mesma posição que o peso
                    array_push($questionsThisAreaType, $question->idPP);
                    
                    for($c = 0; $c < count($arrayQuestSurvey); $c++) {
                        if($arrayQuestSurvey[$c]->idQuestion == $question->id) {
                            array_push($answersThisAreaScore, $answersUserSurvey[$c]); //poe as respostas na mesma posicao
                        }
                    }
                }
            }
            for($i = 0; $i < count($questionsThisAreaWeight); $i++) {
                $totalWeights += $questionsThisAreaWeight[$i]; //junta todos os pesos da area actual
                if($questionsThisAreaType[$i] == 1) {
                    $totalWeightsPerformance += $questionsThisAreaWeight[$i]; //junta os pesos da area actual performance

                }
                else {
                    $totalWeightsPotential += $questionsThisAreaWeight[$i];//junta os pesos da area actual potencial
                }

            }
            for($b = 0; $b < count($questionsThisAreaWeight); $b++) {
                $resultPercentage = ($questionsThisAreaWeight[$b] / $totalWeights) * 100; //divide a percentagem correcta por cada questão
                $resultPercentage = number_format($resultPercentage, 2);
                $totalPercentagesSum += $resultPercentage; //soma todas as percentagens
                array_push($questionsThisAreaPercentagePerQuestion, $resultPercentage);
                array_push($totalPercentagesAllQuestions, $resultPercentage); //põe a percentagem na mesma posição que o peso
                if($questionsThisAreaType[$b] == 1) {
                    $resultPercentagePerformance = ($questionsThisAreaWeight[$b] / $totalWeightsPerformance) * 100;
                    $resultPercentagePerformance = number_format($resultPercentagePerformance, 2);
                    $totalPercentagesSumPerformance += $resultPercentagePerformance;
                    array_push($questionsThisAreaPerformancePotentialPercentagePerQuestion, $resultPercentagePerformance); 
                }
                else {
                    $resultPercentagePotential = ($questionsThisAreaWeight[$b] / $totalWeightsPotential) * 100;
                    $resultPercentagePotential = number_format($resultPercentagePotential, 2);
                    $totalPercentagesSumPotential += $resultPercentagePotential;
                    array_push($questionsThisAreaPerformancePotentialPercentagePerQuestion, $resultPercentagePotential);
                }
            }
            for($b = 0; $b < count($questionsThisAreaWeight); $b++) {
                $weightedScore = ($answersThisAreaScore[$b]->value / $surveyAnswerLimit * $questionsThisAreaPercentagePerQuestion[$b]);
                $weightedScore = number_format($weightedScore, 2);
                array_push($questionsThisAreaWeightedScore, $weightedScore);
                $totalWeightedScoreSum += $weightedScore; //soma todos os weighted scores
                if($questionsThisAreaType[$b] == 1) {
                    $weightedScorePerformance = ($answersThisAreaScore[$b]->value / $surveyAnswerLimit * $questionsThisAreaPerformancePotentialPercentagePerQuestion[$b]);
                    $weightedScorePerformance = number_format($weightedScorePerformance, 2);
                    $totalWeightedScorePerformanceSum += $weightedScorePerformance;
                }
                else {
                    $weightedScorePotential = ($answersThisAreaScore[$b]->value / $surveyAnswerLimit * $questionsThisAreaPerformancePotentialPercentagePerQuestion[$b]);
                    $weightedScorePotential = number_format($weightedScorePotential, 2);
                    $totalWeightedScorePotentialSum += $weightedScorePotential;
                }

            }
            if($totalPercentagesSum != 0) {
                array_push($totalPercentageFinalAll, $area->id, ($totalWeightedScoreSum)); 
                //calculo original seria: ($totalWeightedScoreSum) / ($totalPercentagesSum)
                // mas o total de percentagem será sempre 100, portanto pode-se tirar
                
            }
            if($totalPercentagesSumPerformance != 0 && $totalPercentagesSumPotential != 0) {
                array_push($totalNoPercentagePerformancePotential,$area->id, number_format(($totalWeightedScorePerformanceSum * $surveyAnswerLimit / 100),2), number_format(($totalWeightedScorePotentialSum * $surveyAnswerLimit / 100),2));
            }
            if($totalPercentagesSumPerformance != 0) {
                array_push($totalPercentagePerformanceFinal, $area->id, ($totalWeightedScorePerformanceSum),  number_format(($totalWeightedScorePerformanceSum * $surveyAnswerLimit / 100),2)); 

            }
            if($totalPercentagesSumPotential != 0) {
                array_push($totalPercentagePotentialFinal, $area->id, ($totalWeightedScorePotentialSum), number_format(($totalWeightedScorePotentialSum * $surveyAnswerLimit / 100),2)); 
            }

        }


    //    foreach($totalPercentageFinalAll as $answerGiven) {
    //        echo $answerGiven."<br>";
    //    }


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
        ->with('totalAllQuestions', $totalAllQuestions)
        ->with('totalPercentagesAllQuestions', $totalPercentagesAllQuestions)
        ->with('totalPercentageFinalAll', $totalPercentageFinalAll)
        ->with('totalPercentagePerformanceFinal', $totalPercentagePerformanceFinal)
        ->with('totalPercentagePotentialFinal', $totalPercentagePotentialFinal)
        ->with('totalNoPercentagePerformancePotential', $totalNoPercentagePerformancePotential)
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
