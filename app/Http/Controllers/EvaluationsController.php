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

        foreach($usersSelected as $user) {
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
    

        $showSurveyGeneral = "";
        $selectedSurveyId = $request->input('surveyShowID');

        $showSurveyGeneral .= "<script>";
        $showSurveyGeneral .= 'document.getElementById("surveyShowID").value='.$selectedSurveyId;
        $showSurveyGeneral .= "</script>";

        if($selectedSurveyId == 00) {
            $showSurveyGeneral .= "Select a survey from the dropdown list!";
        }
        else {

            $surveyName = Survey::find($selectedSurveyId)->name;
            $surveyType = Survey::find($selectedSurveyId)->surveyType->description;
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

            //Button Area
            ///////////////
                $showSurveyGeneral .= "<button type='button' onclick='hideArea()'>Add/Remove Areas</button>";
                $showSurveyGeneral .= "<button type='button' onclick='hideSubcat()'>Add/Remove Subcategories</button>";
                $showSurveyGeneral .= "<button type='button' onclick='hideQuestions()'>Add/Remove Questions</button>";
                $showSurveyGeneral .= "<button type='button' onclick='hideUserSurvey()'>Assign/Remove Users</button>";

                $showSurveyGeneral .= "<div style='display: none;' id='hideArea'>";

                $showSurveyGeneral .= '<form action="/createArea">';
                // $showSurveyGeneral .=   '@csrf';
                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
                $showSurveyGeneral .=  'New: <input type="text" name="newArea">';
                $showSurveyGeneral .= '<button type="submit">Create Area</button>';

                $showSurveyGeneral .=  '</form>';

                $showSurveyGeneral .= '<form action="/addAreaToSurvey">'; 
                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
                $showSurveyGeneral .= 'Add: <select name="areaSelect">';
    
                $allAreas = [];        

                foreach($allAreasDB as $area) {
                    if(!in_array($area->description, $allAreas)) {
                        array_push($allAreas, $area->description);
                        $showSurveyGeneral .= '<option value='.$area->id.'>'.$area->description.'</option>';
                    }
                    
                } 
                    
            
    
                $showSurveyGeneral .= '</select>';

                $showSurveyGeneral .= '<select style="display: none;" name="idSurvey">';
                $showSurveyGeneral .= '<option value='.$selectedSurveyId.'></option>';               
                $showSurveyGeneral .= '</select>';
                $showSurveyGeneral .= '<button name="submitArea" type="submit">Add</button>';

                $showSurveyGeneral .= '</form>';
                
                $showSurveyGeneral .= '<form action="/deleteAreasSurvey">';
                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
                if($surveyAreas->count() == 0) {
                    $showSurveyGeneral .= '';   
                }
                else {
                    $showSurveyGeneral .=  "Remove: <select name='areaSurveyRemId'>";
                    foreach($surveyAreas as $sAreas) {
                        $showSurveyGeneral .= '<option value='.$sAreas->id.'and'.$selectedSurveyId.'>'.$sAreas->description.'</option>';   
                    }
                
            
                $showSurveyGeneral .=  "</select>";
                $showSurveyGeneral .= '<button type="submit">Remove Area</button>';
                }
                $showSurveyGeneral .=  '</form>';

                $showSurveyGeneral .= "</div>";
             //End Button Area
            ///////////////


            //Button Subcategory
            ///////////////
                
            
            $showSurveyGeneral .= "<div style='display: none;' id='hideSubcat'>";

            $showSurveyGeneral .= '<form action="/newSubCat">';
            $showSurveyGeneral .= csrf_field();
            $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
            $showSurveyGeneral .= 'New:<input name="subCatNewName">';
            $showSurveyGeneral .= '<button type="submit">Create Subcategory</button>';
            $showSurveyGeneral .= '</form>';
            

        $showSurveyGeneral .= "<form action='/addSubcatArea'>";
        $showSurveyGeneral .= csrf_field();
        $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
        $showSurveyGeneral .= "Add: <select name='selectedSubCat'>";
        $allSubCats = [];
                foreach($subCats as $subCat) {
                    if(!in_array($subCat->description, $allSubCats)) {
                        array_push($allSubCats, $subCat->description);
                        $showSurveyGeneral .= "<option value=$subCat->id>".$subCat->description."</option>";
                    }
                   
                }
             $showSurveyGeneral .= "</select>";
             $showSurveyGeneral .= "<strong>to</strong>";
             $showSurveyGeneral .= "<select name='selectedArea'>";
                    foreach($surveyAreas as $aps) {
                        $showSurveyGeneral .=  "<option value=$aps->id>".$aps->description."</option>";
                    }                
             $showSurveyGeneral .= "</select>";
             $showSurveyGeneral .= "<button>Add</button>";
             $showSurveyGeneral .= "</form>";
             
             $showSurveyGeneral .= "<form action='/remSubcatArea'>";
             $showSurveyGeneral .= csrf_field();
             $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
             $showSurveyGeneral .= "Remove: <select name='choosenAreaSubCatId'>";
                foreach($surveyAreas as $area) {
                    $subCatsArea = Areas::find($area->id)->subCategories()->get();
                    foreach($subCatsArea as $subCat) {
                        $showSurveyGeneral .=  "<option value=".$area->id."and".$subCat->id.">Subcat: ".$subCat->description." | Area: ".$area->description."</option>";
                    }
                    
                }
             $showSurveyGeneral .= "</select>";
             $showSurveyGeneral .= "<button type='submit'>Remove</button>";
             $showSurveyGeneral .= "</form>";

                    
            $showSurveyGeneral .= "</div>";


            //End Button Subcategory
            ///////////////


            //Button Questions
            ///////////////

            $showSurveyGeneral .= "<div style='display: none;' id='hideQuestions'>";
                
                $showSurveyGeneral .= '<form action="/newQuestion">';
                $showSurveyGeneral .= '<input type="hidden" id="questionTypeForm" name="questionTypeForm" value="">';
                $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
                
                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .= 'Type: ';
                foreach($questionTypes as $type) {
                    $showSurveyGeneral .= '<label>'.$type->description.'&nbsp</label>';
                    if($type->description == "Open") {
                        $showSurveyGeneral .= '<input onchange="hideParam()" id="openQuestion" type="radio" name="questionType" value='.$type->id.'>';
                    }
                    else {
                        $showSurveyGeneral .= '<input onchange="hideParam()" type="radio" name="questionType" value='.$type->id.'>';
                    }
                    
                }
                $showSurveyGeneral .= '<br>'; 
                

                $showSurveyGeneral .= "<br>";
                
                
                $showSurveyGeneral .= '<div style="display: none;" id="numericQuestionSelect" value="">';
                $showSurveyGeneral .= 'Write a question to add: <input type="text" name="question"> <br>';
                $showSurveyGeneral .= '<span id="weight">Weight: <input type="number" step="0.01" min="0" name="weight"></span><br>';

                $showSurveyGeneral .= '<div id="params">';
                $showSurveyGeneral .='Parameters: <br>';
                foreach($PPs as $pp) {
                    $showSurveyGeneral .= '<label>'.$pp->description.'</label>&nbsp';
                    $showSurveyGeneral .= '<input type="radio" name="PP" value='.$pp->id.'>';
                }
                $showSurveyGeneral .= '</div>';
                $showSurveyGeneral .= "Add: <select name='choosenSubCatId'>";
                foreach($surveyAreas as $area) {
                    $subCatsArea = Areas::find($area->id)->subCategories()->get();
                    foreach($subCatsArea as $subCat) {
                        $showSurveyGeneral .=  "<option value=".$subCat->id.">Subcat: ".$subCat->description." | Area: ".$area->description."</option>";
                    }
                    
                }
                $showSurveyGeneral .= "</select>";
                $showSurveyGeneral .= "<button type='submit'>Add</button>"; 
                $showSurveyGeneral .= "</div>";

                $showSurveyGeneral .= '<div style="display: none;" id="openQuestionSelect">';
                $showSurveyGeneral .= 'Write a question to add: <input type="text" name="questionOpen"> <br>';

                $showSurveyGeneral .= "Add: <select name='choosenAreaId'>";
                foreach($surveyAreas as $area) {
                        $showSurveyGeneral .=  "<option value=".$area->id.">".$area->description."</option>";                    
                }
                $showSurveyGeneral .= "</select>";
                $showSurveyGeneral .= "<button type='submit'>Add</button>"; 
                $showSurveyGeneral .= "</div>";
                
                
                    
                  
                $showSurveyGeneral .= '</form>';

                $showSurveyGeneral .= 'Remove:'; 
                $showSurveyGeneral .= '<form action="/remQuestion">';
                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
                $showSurveyGeneral .= '<select name="questionIdRemove">';    
                //Mostra todas as subcats das areas de um questionario, assim como as questões de
                //cada subcat. A contagem é para ficar igual ao li do questionário, e remover a 
                //questão certa
                    foreach($surveyAreas as $area) {
                        $subCats = Areas::find($area->id)->subCategories()->get();
                        $openQuestions = Areas::find($area->id)->openQuestions()->orderBy('created_at','asc')->get();
                        foreach($subCats as $subcat) {
                            $subCatsQuestions = subCategories::find($subcat->id)->questions()->orderBy('created_at', 'asc')->get();
                            foreach($subCatsQuestions as $question) {
                                $showSurveyGeneral .= '<option value='.$question->id.'>'.$subcat->description.' | '.'Question: '.$countQuestions.'</option>';
                                $countQuestions++;
                            }
                            $countQuestions = 1;
                            
                        }
                        foreach($openQuestions as $openQuestion){
                            $showSurveyGeneral .= '<option value='.$openQuestion->id.'>'.$area->description.' | '.'Open Question: '.$countQuestions.'</option>';
                            $countQuestions++;
                        }
                        $countQuestions = 1;
                    }
                    // 
                $showSurveyGeneral .= '</select>';
                $showSurveyGeneral .= '<button type="submit">Remove</button>';
                $showSurveyGeneral .= '</form>'; 

            $showSurveyGeneral .= "</div>";

            //End Button Questions
            ///////////////

            //Users
            ///////////////


            $showSurveyGeneral .= "<div style='display: none;' id='hideUserSurvey'>";

                $showSurveyGeneral .= "<form action='/assignUser'>";

                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
                $showSurveyGeneral .= "Assign Users to Survey:<br>";
                foreach($users as $user) {
                    $showSurveyGeneral .= '<input type="checkbox" id='.$user->name.' name="users[]" value='.$user->id.'>';
                    $showSurveyGeneral .= '<label for='.$user->name.'>'.$user->name.'</label>';
                    $showSurveyGeneral .= '<select onchange="showEvaluatedChoice('.$user->id.')" id="evaluatedChoiceJS'.$user->id.'" name="evalChoice'.$user->id.'">';
                    //passamos o user id como argumento no select, para o JS nos mostrar o select correcto
                    $showSurveyGeneral .= '<option value="1">...will be evaluated.</option>';
                    $showSurveyGeneral .= '<option value="0">...will evalue</option>';
                    $showSurveyGeneral .= '</select>'; 
                    $showSurveyGeneral .= "<select style='display: none;' id='showEvaluatedSelection".$user->id."' name='evaluatorChoice".$user->id."'>";
                    foreach($users as $toBeEval) {
                        $showSurveyGeneral .= '<option value='.$toBeEval->id.'>'.$toBeEval->name.'</option>';
                    }
                    $showSurveyGeneral .= "</select>";
                    $showSurveyGeneral .= "<br>";
                }
  
                $showSurveyGeneral .= "<br>";
                $showSurveyGeneral .= '<label for="limitDate">Limit Date:</label>';
                $showSurveyGeneral .= '<input type="date" id="limitDate" name="limitDate">';
                $showSurveyGeneral .= "<br>";
                $showSurveyGeneral .= "<button type='submit'>Assign Users</button>";
                $showSurveyGeneral .= "</form>";
                $showSurveyGeneral .= "<br>";

                $showSurveyGeneral .= "<form action='/remUser'>";
                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .= '<input type="hidden" name="idSurveyAutoShow" value='.$selectedSurveyId.'>';
                $showSurveyGeneral .= "Remove:<br>";
                $usersAssigned = Survey::find($selectedSurveyId)->users()->get();
                $count2 = 0;
                foreach($usersAssigned as $user) {
                    $count2++;
                    if($count2 == 2){
                       $showSurveyGeneral .= '<input type="checkbox" id='.$user->name.' name="usersRem[]" value='.$user->id.'>';
                       $showSurveyGeneral .= '<label for='.$user->name.'>'.$user->name.'</label><br>';
                       $count2 = 0;
                    }
                    else {
                       $showSurveyGeneral .= '<input type="checkbox" id='.$user->name.' name="usersRem[]" value='.$user->id.'>';
                       $showSurveyGeneral .= '<label for='.$user->name.'>'.$user->name.'</label>&nbsp;&nbsp;';
                    }
                   }

                   $showSurveyGeneral .= "<button type='submit'>Remove Users</button>";
                   $showSurveyGeneral .= "</form>";
                    

            $showSurveyGeneral .= "</div>";

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
                                $showSurveyGeneral .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;There are no questions in this subcategory!";
                            }
                            else {
                                $showSurveyGeneral .= "<ol>";
                                foreach($subCatsQuestions as $question) {
                                    if($question->idTypeQuestion == 2) {
                                        $showSurveyGeneral .= "&nbsp;&nbsp;&nbsp;&nbsp;<li>".$question->description."</li>";
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
                $showSurveyGeneral .= "<strong>Users assigned:</strong> <br>";
                foreach($usersEvaluated as $user) {
                    if($user->evaluated == 1) {
                        $showSurveyGeneral .= User::find($user->idUser)->name." will autoevaluate himself.<br>";
                    }
                    else {
                        $showSurveyGeneral .= User::find($user->idUser)->name." will evalue ".User::find($user->willEvaluate)->name.".<br>";
                    }
                    
                }
                



            $showSurveyGeneral .= "</div>";



            //End Survey Structure

        }

        

        return redirect()->action('EvaluationsController@index')->with('showSurvey', $showSurveyGeneral);

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
