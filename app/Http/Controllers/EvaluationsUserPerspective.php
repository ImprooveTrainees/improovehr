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
use App\questSurvey;
use App\Answers;
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
        $surveysHTML = [];
        $surveysHTMLType = [];
        $daysLeftSurveyHTML = [];
        $dateLimitSurveyHTML = [];
        $submittedSurveyHTML = [];
        
       
        foreach($surveyUser as $survey) {
            $dateLimit = surveyUsers::where('idSurvey',$survey->id)->where('idUser', $authUser)->first()->dateLimit;
            $todayDate = date_create(date("Y-m-d"));
            $Limit = date_create($dateLimit);
            $daysLeft = date_diff($todayDate, $Limit); 
            array_push($surveysHTML,$survey);
            array_push($surveysHTMLType, $survey->surveyType->description);
            if($todayDate > $Limit) {
                array_push($daysLeftSurveyHTML, "Expired");
                array_push($dateLimitSurveyHTML, "");
            }
            else {
                array_push($daysLeftSurveyHTML, $daysLeft);
                array_push($dateLimitSurveyHTML, $Limit->format('Y-m-d'));
            }
            $submitted = surveyUsers::where('idSurvey', $survey->id)->where('idUser', $authUser)->first()->submitted;
            array_push($submittedSurveyHTML, $submitted); 

        }

        return view('testeEvalsUserPerspectiveIndex')
        ->with('surveysHTML', $surveysHTML)
        ->with('surveysHTMLType', $surveysHTMLType)
        ->with('daysLeftSurveyHTML', $daysLeftSurveyHTML)
        ->with('dateLimitSurveyHTML', $dateLimitSurveyHTML)
        ->with('submittedSurveyHTML', $submittedSurveyHTML)
        ->with('surveyUserMsg',$surveyUserMsg)
        ->with('authUser', $authUser); //user autenticado
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
    public function storeAnswers(Request $request)
    {
        //
        $questionsID = $request->input("questions"); //hidden input para saber a qual questão pertence a resposta
        $answers = $request->input("answers");
        $surveyId = $request->input("selectedSurveyId");
        $authUser = Auth::User()->id;

        for($i = 0; $i < count($questionsID); $i++) {
            $questSurvey = questSurvey::where('idSurvey', $surveyId)->where('idQuestion', $questionsID[$i])->first();
            $newAnswer = new Answers;
            $newAnswer->idQuestSurvey = $questSurvey->id;
            $newAnswer->value = $answers[$i]; //todas as respostas vão ter um igual nr de perguntas
            $surveyUser = surveyUsers::where('idUser', $authUser)->where('idSurvey', $surveyId)->first();
            if($surveyUser->evaluated == 1) { //se o user tiver ligado ao survey como avaliado.
                $newAnswer->idUser = $authUser;
                $newAnswer->evaluated = true;
            }
            else { //se o user tiver ligado ao survey como avaliador.
                $newAnswer->idUser = $authUser;
                $newAnswer->evaluated = false;
                $newAnswer->willEvalue = $surveyUser->willEvaluate;

            }
            $newAnswer->save();
        } //insere as respostas já com a questão associada

        $surveyUser = surveyUsers::where('idUser', $authUser)->where('idSurvey', $surveyId)->first();
        $surveyUser->submitted = true;
        $surveyUser->save();


        $msg = "Survey Submited";

        return redirect()->action('EvaluationsUserPerspective@index')
        ->with('completed', $msg);

        
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

        //para sabermos que quem vai avaliar quem no header do questionario
        $authUser = Auth::User()->id;
        $willEvaluateUser = surveyUsers::where('idUser', $authUser)->where('idSurvey', $selectedSurveyId)->first()->willEvaluate;
        $willEvaluateNameUser = User::find($willEvaluateUser)->name;
        //


        $surveyName = Survey::find($selectedSurveyId)->name;
        $surveyType = Survey::find($selectedSurveyId)->surveyType;
        $surveyAnswerLimit = Survey::find($selectedSurveyId)->answerLimit;
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
    'surveyAnswerLimit',
    'selectedSurveyId',
    'willEvaluateNameUser'
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
