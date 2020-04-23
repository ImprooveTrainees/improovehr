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
        $showSurveyGeneral = "";
        $selectedSurveyId = $id;

            $surveyName = Survey::find($selectedSurveyId)->name;
            $surveyType = Survey::find($selectedSurveyId)->surveyType->description;
            $surveyTypeId = Survey::find($selectedSurveyId)->surveyType->id;

            $authUser = Auth::User()->id; //User logged in
            $usersSurvey = surveyUsers::where('idSurvey', $selectedSurveyId)->get(); //all users from survey

            $allAreasDB = Areas::All();
            $surveys = Survey::All();
            $subCats = subCategories::All();
            $PPs = PP::All();
            $users = User::All();
            $questionTypes = typeQuestion::All();
            $surveyAreas = Survey::find($selectedSurveyId)->areas()->get();
            $countQuestions = 1;

            $showSurveyGeneral .= "<h4>".$surveyName."</h4>";
            $showSurveyGeneral .= "<h4>".$surveyType."</h4>";
            if($surveyTypeId == 1) {
                $showSurveyGeneral .= "<h5>This is your periodic evaluation. Above you will find three main areas that will be evaluated regarding your performance in the last semester. Please answer with honesty and clarity.</h5>";
            }
            $showSurveyGeneral .= "<br>";
            $showSurveyGeneral .= "<h6 style='color:#990000;'>Please rate the following sentences on a scale of 1 to ".Survey::find($selectedSurveyId)->answerLimit.", where 1 represents 'Poor' and ".Survey::find($selectedSurveyId)->answerLimit." represents 'Excellent'.</h6>";
            $showSurveyGeneral .= "<br>";
            //Survey Structure
            if($surveyAreas->count() == 0) {
                $showSurveyGeneral .= "<br>";
                $showSurveyGeneral .= "There are no areas in this survey yet!";
            }
            else {
                $showSurveyGeneral .= "<ul>";
                for($i = 0; $i < $surveyAreas->count(); $i++){
                    $showSurveyGeneral .= "<li><strong>".$surveyAreas[$i]->description."</strong></li>";
                    $subCats = Areas::find($surveyAreas[$i]->id)->subCategories()->get();
                    if($subCats->count() == 0) {
                        $showSurveyGeneral .= "There are no subcategories in this area yet!";
                    }
                    else {
                        foreach($subCats as $subcatArea) {
                            $showSurveyGeneral .= "&nbsp;&nbsp;<strong>".$subcatArea->description."</strong>";
                            $subCatsQuestions = subCategories::find($subcatArea->id)->questions()->orderBy('created_at', 'asc')->get();
                            
                            if($subCatsQuestions->count() == 0) {
                                $showSurveyGeneral .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;There are no questions in this subcategory!";
                            }
                            else {
                                $showSurveyGeneral .= "<ol>";
                                foreach($subCatsQuestions as $question) {
                                    if($question->idTypeQuestion == 2) {
                                        $showSurveyGeneral .= "&nbsp;&nbsp;&nbsp;&nbsp;<li>".$question->description."&nbsp;&nbsp;<input placeholder='1-".Survey::find($selectedSurveyId)->answerLimit."' required type='number' name='quantity' min='1' max='".Survey::find($selectedSurveyId)->answerLimit."'></li>";
                                    } //mostra apenas as questões numéricas, e não as abertas, pois estas não
                                      //têm subcategoria
                                    
                                }
                                $showSurveyGeneral .= "</ol>";
                            }
                           
                        }
                    }
                }
                $showSurveyGeneral .= "</ul>";
                $showSurveyGeneral .= "<strong>Open ended questions:</strong><br>";
                $showSurveyGeneral .= "<ul>";
                foreach($surveyAreas as $sAreasOpen) {
                        $showSurveyGeneral .= "<li><strong>".$sAreasOpen->description."</strong></li>";
                        $openQuestions = Areas::find($sAreasOpen->id)->openQuestions()->orderBy('created_at', 'asc')->get();
                        if($openQuestions->count() == 0) {
                            $showSurveyGeneral .= "There are no open questions for this area!";
                        }
                        else {
                            $showSurveyGeneral .= "<ol>";
                            foreach($openQuestions as $openQuestion) {
                                $showSurveyGeneral .= "<li>".$openQuestion->description."</li>";
                                $showSurveyGeneral .=  '<textarea placeholder="Insert an answer" id="w3mission" rows="4" cols="50">';
                                $showSurveyGeneral .=  '</textarea>';
                            }
                            $showSurveyGeneral .= "</ol>";
                        }
                        
                } //aqui procura só as questoes abertas, que não têm subcategoria
                $showSurveyGeneral .= "</ul>";
            }
           
            



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
