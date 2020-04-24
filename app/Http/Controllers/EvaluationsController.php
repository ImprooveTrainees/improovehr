<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\surveyType;
use App\Survey;
use App\Areas;
use App\AreasQuestConnect;
use App\subCategories;
use App\PP;
use App\typeQuestion;
use App\Questions;
use App\questSurvey;
use App\User;
use App\surveyUsers;

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
        $surveys = Survey::All();
        $clickedShow = false; //será posto true na funcao "show"
        
    

        return view('testeCreateEvals')->with('surveyTypes', $surveyTypes)
        ->with('surveys', $surveys)->with('clickedShow', $clickedShow);
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
        $allSurveys = Survey::All();
        $surveyName = $request->input('surveyName');
        $answLimit = $request->input('answerLimit');
        $surveyType = $request->input('surveyType');

        $survey->name = $surveyName;
        $survey->answerLimit = $answLimit;
        $survey->idSurveyType = $surveyType;

        $survey->save();

        $msg = "Survey created successfully";



        return redirect()->action('EvaluationsController@index')->with('msgError', $msg);
    }
    


    public function createArea(Request $request)
    {
        //
        $areas = new Areas;

        $areaName = $request->input('newArea');

        $areas->description = $areaName;
        $areas->save();

        $areaSuccess = "Area created successfully!";

         $areaSuccess .= "<script>";
         $areaSuccess .= 'document.getElementById("surveyShowID").value='.$request->input('idSurveyAutoShow');
         $areaSuccess .= "</script>";
         $areaSuccess .= "<script>";
         $areaSuccess .= 'document.getElementById("showSurvey").submit();';
         $areaSuccess .= "</script>";


        return redirect()->action('EvaluationsController@index')->with('msgError', $areaSuccess);
    }

    public function newSubCat(Request $request)
    {
        //
        $subcat = new subCategories;
        $subCatName = $request->input('subCatNewName');
        $allSubCats = subCategories::All();
        $existe = false;
        foreach($allSubCats as $subCat) {
            if($subCatName == $subCat->description) {
                $existe = true;
                break;
            }
        }

        if($existe) {
            $subCatNewMsg = "Subcategory already exists!";
        }
        else {
            $subcat->description = $subCatName;
            $subcat->save();
            $subCatNewMsg = "Subcategory successfully created!";
        }

         //faz com que após a página carregar ele mostre o questionário previamente seleccionado
         $subCatNewMsg .= "<script>";
         $subCatNewMsg .= 'document.getElementById("surveyShowID").value='.$request->input('idSurveyAutoShow');
         $subCatNewMsg .= "</script>";
         $subCatNewMsg .= "<script>";
         $subCatNewMsg .= 'document.getElementById("showSurvey").submit();';
         $subCatNewMsg .= "</script>";

        return redirect()->action('EvaluationsController@index')->with('msgError', $subCatNewMsg);
    }

    public function addAreaToSurvey(Request $request)
    {
        //
        $area = new Areas;
        $areaEQuest = new AreasQuestConnect;
        $surveySelected = Survey::find($request->input('idSurvey'))->id;
        $areaSurveyConnection = new AreasQuestConnect;

        
        $exists = false;
        $areaEQuest = AreasQuestConnect::All();   
        $areaName = Areas::find($request->input('areaSelect'))->description;
        $areaInSurveyMsg = "";

                //verifica se já existe
                foreach($areaEQuest as $aQ) {
                    if($aQ->idSurvey == $surveySelected && Areas::find($aQ->idArea)->description == $areaName) {
                        $exists = true;
                        break;
                    }
                }
                if($exists) {
                    $areaInSurveyMsg = "This area already exists in this survey!";
                }
                else {
                    $area->description = $areaName;
                    $area->save();
            
                    $areaSurveyConnection->idArea = $area->id;
                    $areaSurveyConnection->idSurvey = $surveySelected;
                    $areaSurveyConnection->save();
                    $areaInSurveyMsg = "Area added to survey successfully";
                }
                
                //faz com que após a página carregar ele mostre o questionário previamente seleccionado
                 $areaInSurveyMsg .= "<script>";
                 $areaInSurveyMsg .= 'document.getElementById("surveyShowID").value='.$surveySelected;
                 $areaInSurveyMsg .= "</script>";
                 $areaInSurveyMsg .= "<script>";
                 $areaInSurveyMsg .= 'document.getElementById("showSurvey").submit();';
                 $areaInSurveyMsg .= "</script>";

                return redirect()->action('EvaluationsController@index')
                ->with('msgError', $areaInSurveyMsg);

        
 


        
    }



    public function createQuestion(Request $request)
    {
        //
        $newQuestion = new Questions;
        $newQuestSurvey = new questSurvey;
        $surveyID = $request->input('idSurveyAutoShow');
        //o JS altera o value do input dependendo da op seleccionada
        if($request->input('questionTypeForm') == 1) {
            $question = $request->input('question');
            $questionType = $request->input('questionType');
            $weight = $request->input('weight');
            $PP = $request->input('PP');
            $idSubCat = $request->input('choosenSubCatId');

            $newQuestion->description = $question;
            $newQuestion->weight = $weight;
            $newQuestion->idPP = $PP;
            $newQuestion->idSubcat = $idSubCat;
            $newQuestion->idTypeQuestion = $questionType;

            $newQuestion->save();
            
            $newQuestSurvey->idSurvey = $surveyID;
            $newQuestSurvey->idQuestion = $newQuestion->id;
            $newQuestSurvey->save();

          

            $msg = "Question successfully added to subcategory!";
        }
        else if($request->input('questionTypeForm') == 2) {
            $question = $request->input('questionOpen');
            $questionType = $request->input('questionType');
            $idAreaOpen = $request->input('choosenAreaId');

            $newQuestion->description = $question;
            $newQuestion->idAreaOpenQuest = $idAreaOpen;
            $newQuestion->idTypeQuestion = $questionType;

            $newQuestion->save();

            $newQuestSurvey->idSurvey = $surveyID;
            $newQuestSurvey->idQuestion = $newQuestion->id;
            $newQuestSurvey->save();


            $msg = "Open question successfully added to area!";
        }
        
                 $msg .= "<script>";
                 $msg .= 'document.getElementById("surveyShowID").value='.$surveyID;
                 $msg .= "</script>";
                 $msg .= "<script>";
                 $msg .= 'document.getElementById("showSurvey").submit();';
                 $msg .= "</script>";
    

       

        return redirect()->action('EvaluationsController@index')
         ->with('msgError', $msg);
    }

    public function removeQuestion(Request $request) {
        //
        $questionId = $request->input('questionIdRemove');
        Questions::find($questionId)->questSurveys()->first()->delete();
        Questions::find($questionId)->delete();
        $msg = "Question removed successsfully!";

        $msg .= "<script>";
        $msg .= 'document.getElementById("surveyShowID").value='.$request->input('idSurveyAutoShow');
        $msg .= "</script>";
        $msg .= "<script>";
        $msg .= 'document.getElementById("showSurvey").submit();';
        $msg .= "</script>";

        return redirect()->action('EvaluationsController@index')
         ->with('msgError', $msg);
    }

    
    // public function showAreasSurvey(Request $request)
    // {
    //     //
      

        
    //     $idSurveySelected = $request->input('idSurvey');
    //     $areasInSurvey = Survey::find($idSurveySelected)->areas()->get();
    //     $surveyName = Survey::find($idSurveySelected)->name;
    //     $areasInSurveyMsg = "Areas in <strong>".$surveyName.":</strong> <br>";
    //     foreach($areasInSurvey as $areas) {
    //         $areasInSurveyMsg .= $areas->description." "."<button name='submitAreasPerSurveys' type='Submit' value=$idSurveySelected"."and"."$areas->id".">Delete Area</button>"."<br>";
    //         //cada botao vai ter o id da area e do survey, que será passado para a função de delete.

    //     }
    //     return redirect()->action('EvaluationsController@index')
    //     ->with('areasPerSurvey', $areasInSurveyMsg);


        
        
        
    // }

    public function deleteAreasSurvey(Request $request)
    {
        //
        //com o explode separamos o id do survey do id da area.
        $idAreaAndSurvey = explode("and", $request->input('areaSurveyRemId'));
        
        AreasQuestConnect::where('idSurvey',  $idAreaAndSurvey[1])
        ->where('idArea', $idAreaAndSurvey[0])->first()->delete();

        subCategories::where('idArea', $idAreaAndSurvey[0])->delete();

        $areaInSurveyMsg = "This area and her subcategories were deleted successfully from survey!";
        $areaInSurveyMsg .= "<script>";
        $areaInSurveyMsg .= 'document.getElementById("surveyShowID").value='.$idAreaAndSurvey[1];
        $areaInSurveyMsg .= "</script>";
        $areaInSurveyMsg .= "<script>";
        $areaInSurveyMsg .= 'document.getElementById("showSurvey").submit();';
        $areaInSurveyMsg .= "</script>";

        return redirect()->action('EvaluationsController@index')
            ->with('msgError', $areaInSurveyMsg);

    }

    // public function surveysSubcat(Request $request)
    // {
    //     //
    //     $idSurveySelected = $request->input('idSurvey');
    //     $msg = "";

    //     if($idSurveySelected == 00) {
    //         $msg = "Select a survey from the dropdown list!";
    //     }
    //     else {
    //     $areaPerSurvey = Survey::find($idSurveySelected)->areas()->get();
    //     $subCats = subCategories::All();

    //     $msg .= "<strong>".Survey::find($idSurveySelected)->name."</strong>"."<br>";
    //     $msg .= "--------<br>";
    //     $msg .= "<strong>Add Subcategory to Area:</strong><br>";
    //     $msg .= "<form action='/addSubcatArea'>";
    //     $msg .= "<select name='selectedSubCat'>";
    //     $allSubCats = [];
    //             foreach($subCats as $subCat) {
    //                 if(!in_array($subCat->description, $allSubCats)) {
    //                     array_push($allSubCats, $subCat->description);
    //                     $msg .= "<option value=$subCat->id>".$subCat->description."</option>";
    //                 }
                   
    //             }
    //     $msg .= "</select>";
    //     $msg .= "<br>";
    //     $msg .= "<strong>to</strong><br>";
    //     $msg .= "<select name='selectedArea'>";
    //                 foreach($areaPerSurvey as $aps) {
    //     $msg .=           "<option value=$aps->id>".$aps->description."</option>";
    //                 }                
    //     $msg .= "</select>";
    //     $msg .= "<button>Add</button>";
    //     $msg .= "</form>";
    //     }

    //     return redirect()->action('EvaluationsController@index')
    //         ->with('areasPerSurveySubcat', $msg);

    // }

    public function addSubcatArea(Request $request)
    {
        //
        //em vez de associar o id da subcat existente, é criado um novo com a ilusão que 
        //seleccionamos o existente, como foi feito nas areas.

        $newSubCat = new subCategories;
        $selectedSubCatDescription = subCategories::find($request->input('selectedSubCat'))->description;
        $selectedArea = $request->input('selectedArea');
        $allSubCatsFromArea = Areas::find($selectedArea)->subCategories()->get();
        $existe = false;
        $msg = "";
        foreach($allSubCatsFromArea as $subCArea) {
            if($selectedSubCatDescription == $subCArea->description) {
                $existe = true;
                break;
            }
        }
        if($existe) {
            $msg = "Subcategorie already exists in this area!";
        }
        else {
            $newSubCat->idArea = $selectedArea;
            $newSubCat->description = $selectedSubCatDescription;

            $newSubCat->save();

            $msg = "Subcategorie sucessfully added to area!";
        }


        $msg .= "<script>";
        $msg .= 'document.getElementById("surveyShowID").value='.$request->input('idSurveyAutoShow');
        $msg .= "</script>";
        $msg .= "<script>";
        $msg .= 'document.getElementById("showSurvey").submit();';
        $msg .= "</script>";
        

        return redirect()->action('EvaluationsController@index')
            ->with('msgError', $msg);



    }

     public function removeSubcatArea(Request $request)
    {
        //
        $areaAndSubcatId = explode("and", $request->input('choosenAreaSubCatId'));

        subCategories::find($areaAndSubcatId[1])->delete();
        $msg = "Subcategorie removed with success from this area!";
        

        $msg .= "<script>";
        $msg .= 'document.getElementById("surveyShowID").value='.$request->input('idSurveyAutoShow');
        $msg .= "</script>";
        $msg .= "<script>";
        $msg .= 'document.getElementById("showSurvey").submit();';
        $msg .= "</script>";

        return redirect()->action('EvaluationsController@index')
            ->with('msgError', $msg);

    }

    public function assignUser(Request $request)
    {
        //
        
        $usersSelected = $request->input('users');
        if($usersSelected == 0) {
            $msg = "Select users to add!";
        }
        else {

        
        $dateLimit = $request->input('limitDate');
        $survey = $request->input('idSurveyAutoShow');
        $msg = "Users assigned successfully!";
        $allSurveyUsers = surveyUsers::All();

        foreach($usersSelected as $user) {
            foreach($allSurveyUsers as $all) {
                if($all->idUser == $user && $all->idSurvey == $survey){ //verifica se já existe o user no survey
                    $msg = "That user is already assigned to this survey!";
                    break 2;
                }
            }
            $newSurveyUsers = new surveyUsers;
            $newSurveyUsers->idUser = $user;
            $newSurveyUsers->idSurvey = $survey;
            $newSurveyUsers->submitted = false;
            $newSurveyUsers->dateLimit = $dateLimit;
            $evalChoice = $request->input('evalChoice'.$user); //como há vários selects num ciclo for, damos o nome de cada select com o seu userId, e aqui pedimos o valor do select de cada user
            if($request->input('evaluatorChoice'.$user) != null) {
                $evaluatorChoice = $request->input('evaluatorChoice'.$user);
                $newSurveyUsers->willEvaluate = $evaluatorChoice;
            }
            $newSurveyUsers->evaluated = $evalChoice;
            $newSurveyUsers->save();
        }
    }
        $msg .= "<script>";
        $msg .= 'document.getElementById("surveyShowID").value='.$request->input('idSurveyAutoShow');
        $msg .= "</script>";
        $msg .= "<script>";
        $msg .= 'document.getElementById("showSurvey").submit();';
        $msg .= "</script>";

        return redirect()->action('EvaluationsController@index')
            ->with('msgError', $msg);



    }

    public function remUser(Request $request)
    {
        //
        $usersSelected = $request->input('usersRem');
        $survey = $request->input('idSurveyAutoShow');

        if($usersSelected == 0) {
            $msg = "Select users to remove!";
        }
        else {   
            $msg = "Users removed successfully!";
        foreach($usersSelected as $usersRem) {
            surveyUsers::where('idUser', $usersRem)->where('idSurvey', $survey)->delete();
        }
    }
        $msg .= "<script>";
        $msg .= 'document.getElementById("surveyShowID").value='.$request->input('idSurveyAutoShow');
        $msg .= "</script>";
        $msg .= "<script>";
        $msg .= 'document.getElementById("showSurvey").submit();';
        $msg .= "</script>";

        return redirect()->action('EvaluationsController@index')
            ->with('msgError', $msg);
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
    public function show(Request $request)
    {
        //
        
        $clickedShow = true;
        $showSurveyGeneral = "";
        $selectedSurveyId = $request->input('surveyShowID');

        $showSurveyGeneral .= "<script>";
        $showSurveyGeneral .= 'document.getElementById("surveyShowID").value='.$selectedSurveyId;
        $showSurveyGeneral .= "</script>";

        $surveyName = Survey::find($selectedSurveyId)->name;
        $surveyType = Survey::find($selectedSurveyId)->surveyType->description;
        $allAreasDB = Areas::All();
        $subCats = subCategories::All();
        $PPs = PP::All();
        $users = User::All();
        $questionTypes = typeQuestion::All();
        $surveyAreas = Survey::find($selectedSurveyId)->areas()->get();
        $countQuestions = 1;

        //index
        $surveyTypes = surveyType::All();
        $surveys = Survey::All();
        //

        //Button Area
        ///////////////
        $allAreas = [];
        $allAreasId = [];
            

            foreach($allAreasDB as $area) {
            if(!in_array($area->description, $allAreas)) {
                array_push($allAreas, $area->description);
                array_push($allAreasId, $area->id);
                }
            
            }
                
             //End Button Area
            ///////////////

            //Button Subcategory
            ///////////////
  
            $allSubCats = [];
            $allSubCatsId = [];
            foreach($subCats as $subCat) {
                if(!in_array($subCat->description, $allSubCats)) {
                    array_push($allSubCats, $subCat->description);
                    array_push($allSubCatsId, $subCat->id);
                    
                }
               
            }  //para não repetir as subcats

            $subCatsLoop = "";
            foreach($surveyAreas as $area) {
            $subCatsArea = Areas::find($area->id)->subCategories()->get();
            foreach($subCatsArea as $subCat) {
                $subCatsLoop .= "<option value=".$area->id."and".$subCat->id.">Subcat: ".$subCat->description." | Area: ".$area->description."</option>";
                }
            
            }

            //End Button Subcategory
            ///////////////

            //Button Questions
            ///////////////

            $subCatsLoopQuestions = "";
            foreach($surveyAreas as $area) {
                $subCatsArea = Areas::find($area->id)->subCategories()->get();
                foreach($subCatsArea as $subCat) {
                    $subCatsLoopQuestions .=  "<option value=".$subCat->id.">Subcat: ".$subCat->description." | Area: ".$area->description."</option>";
                }
                
            }
            //Mostra todas as subcats das areas de um questionario, assim como as questões de
            //cada subcat. A contagem é para ficar igual ao li do questionário, e remover a 
            //questão certa 
            $openQuestionsLoop = "";
            $NumericQuestionsLoop = "";

            foreach($surveyAreas as $area) {
                $subCats = Areas::find($area->id)->subCategories()->get();
                $openQuestions = Areas::find($area->id)->openQuestions()->orderBy('created_at','asc')->get();
                foreach($subCats as $subcat) {
                    $subCatsQuestions = subCategories::find($subcat->id)->questions()->orderBy('created_at', 'asc')->get();
                    foreach($subCatsQuestions as $question) {
                        $NumericQuestionsLoop .= '<option value='.$question->id.'>'.$subcat->description.' | '.'Question: '.$countQuestions.'</option>';
                        $countQuestions++;
                    }
                    $countQuestions = 1;
                    
                }
                foreach($openQuestions as $openQuestion){
                    $openQuestionsLoop .= '<option value='.$openQuestion->id.'>'.$area->description.' | '.'Open Question: '.$countQuestions.'</option>';
                    $countQuestions++;
                }
                $countQuestions = 1;
            }

            
            //End Button Questions
            ///////////////

            //Users
            ///////////////
            $usersAssigned = Survey::find($selectedSurveyId)->users()->get();

            //End Users 
            ///////////////
                    
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
                                $showSurveyGeneral .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;There are no questions in this subcategory!<br>";
                            }
                            else {
                                $showSurveyGeneral .= "<ol>";
                                foreach($subCatsQuestions as $question) {
                                    if($question->idTypeQuestion == 2) {
                                        if($question->idPP == 2) { //verifica se é potencial para alterar a cor
                                            $showSurveyGeneral .= "&nbsp;&nbsp;&nbsp;&nbsp;<li style='color:blue;'>".$question->description."</li>";
                                        }
                                        else {
                                            $showSurveyGeneral .= "&nbsp;&nbsp;&nbsp;&nbsp;<li>".$question->description."</li>";
                                        }
                                        
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
                            }
                            $showSurveyGeneral .= "</ol>";
                        }
                        
                } //aqui procura só as questoes abertas, que não têm subcategoria
                $showSurveyGeneral .= "</ul>";
            }
            //Users assigned
            $usersEvaluated = surveyUsers::where('idSurvey', $selectedSurveyId)->get();
            $showSurveyGeneral .= "<div>";
                $showSurveyGeneral .= "<strong>Users assigned:</strong>";
                if($usersEvaluated->count() == 0) {
                    $showSurveyGeneral .= " There are no users assigned to this survey!";
                }
                else {
                $showSurveyGeneral .= "<br>";
                foreach($usersEvaluated as $user) {            
                    if($user->evaluated == 1) {
                        $showSurveyGeneral .=  "<strong>".User::find($user->idUser)->name."</strong> will autoevaluate himself.<br>";
                    }
                    else {
                        $showSurveyGeneral .= "<strong>".User::find($user->idUser)->name."</strong> will evalue <strong>".User::find($user->willEvaluate)->name."</strong><br>";
                    }
                    
                }    

            }

            $showSurveyGeneral .= "</div>";

            //End Survey Structure


        return view('testeCreateEvals')->with(compact('showSurveyGeneral', 'surveyTypes', 'surveys',
        'surveyName','surveyType', 
        'selectedSurveyId', 'allAreas', 'allAreasDB','surveyAreas','allAreasId', 'allSubCats', 
        'allSubCatsId', 'subCatsLoop', 'questionTypes', 'PPs', 'subCatsLoopQuestions',
        'NumericQuestionsLoop','openQuestionsLoop', 'usersAssigned', 'users',
        'usersEvaluated',
        ))->with('clickedShow', $clickedShow);

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
