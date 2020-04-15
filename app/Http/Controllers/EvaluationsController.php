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


        return redirect()->action('EvaluationsController@index');
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
                

            

                return redirect()->action('EvaluationsController@index')
                ->with('msgError', $areaInSurveyMsg);

        
 


        
    }



    public function createQuestion(Request $request)
    {
        //
        $newQuestion = new Questions;
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

            $msg = "Open question successfully added to area!";
        }
        
    

       

        return redirect()->action('EvaluationsController@index')
         ->with('msgError', $msg);
    }

    
    public function showAreasSurvey(Request $request)
    {
        //
      

        
        $idSurveySelected = $request->input('idSurvey');
        $areasInSurvey = Survey::find($idSurveySelected)->areas()->get();
        $surveyName = Survey::find($idSurveySelected)->name;
        $areasInSurveyMsg = "Areas in <strong>".$surveyName.":</strong> <br>";
        foreach($areasInSurvey as $areas) {
            $areasInSurveyMsg .= $areas->description." "."<button name='submitAreasPerSurveys' type='Submit' value=$idSurveySelected"."and"."$areas->id".">Delete Area</button>"."<br>";
            //cada botao vai ter o id da area e do survey, que será passado para a função de delete.

        }
        return redirect()->action('EvaluationsController@index')
        ->with('areasPerSurvey', $areasInSurveyMsg);


        
        
        
    }

    public function deleteAreasSurvey(Request $request)
    {
        //
        //com o explode separamos o id do survey do id da area.
        $idAreaAndSurvey = explode("and", $request->input('areaSurveyRemId'));
        
        AreasQuestConnect::where('idSurvey',  $idAreaAndSurvey[1])
        ->where('idArea', $idAreaAndSurvey[0])->first()->delete();

        subCategories::where('idArea', $idAreaAndSurvey[0])->delete();

        $areaInSurveyMsg = "This area and her subcategories were deleted successfully from survey!";

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

        

        return redirect()->action('EvaluationsController@index')
            ->with('msgError', $msg);



    }

     public function removeSubcatArea(Request $request)
    {
        //
        $areaAndSubcatId = explode("and", $request->input('choosenAreaSubCatId'));

        subCategories::find($areaAndSubcatId[1])->delete();
        $msg = "Subcategorie removed with success from this area!";

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
            $questionTypes = typeQuestion::All();
            $surveyAreas = Survey::find($selectedSurveyId)->areas()->get();          
            $showSurveyGeneral .= "<h4>".$surveyName."</h4>";
            $showSurveyGeneral .= "<h4>".$surveyType."</h4>";

            //Button Area
            ///////////////
                $showSurveyGeneral .= "<button type='button' onclick='hideArea()'>Add/Remove Areas</button>";
                $showSurveyGeneral .= "<button type='button' onclick='hideSubcat()'>Add/Remove Subcategories</button>";
                $showSurveyGeneral .= "<button type='button' onclick='hideQuestions()'>Add/Remove Questions</button>";

                $showSurveyGeneral .= "<div style='display: none;' id='hideArea'>";

                $showSurveyGeneral .= '<form action="/createArea">';
                // $showSurveyGeneral .=   '@csrf';
                $showSurveyGeneral .= csrf_field();
                $showSurveyGeneral .=  'New: <input type="text" name="newArea">';
                $showSurveyGeneral .= '<button type="submit">Create Area</button>';

                $showSurveyGeneral .=  '</form>';

                $showSurveyGeneral .= '<form action="/addAreaToSurvey">'; 
                $showSurveyGeneral .= csrf_field();
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
                $showSurveyGeneral .=  "Remove: <select name='areaSurveyRemId'>";
                    foreach($surveyAreas as $sAreas) {
                        $showSurveyGeneral .= '<option value='.$sAreas->id.'and'.$selectedSurveyId.'>'.$sAreas->description.'</option>';   
                    }
                $showSurveyGeneral .=  "</select>";
                $showSurveyGeneral .= '<button type="submit">Remove Area</button>';
                $showSurveyGeneral .=  '</form>';

                $showSurveyGeneral .= "</div>";
             //End Button Area
            ///////////////


            //Button Subcategory
            ///////////////
                
            
            $showSurveyGeneral .= "<div style='display: none;' id='hideSubcat'>";

            $showSurveyGeneral .= '<form action="/newSubCat">';
            $showSurveyGeneral .= csrf_field();
            $showSurveyGeneral .= 'New:<input name="subCatNewName">';
            $showSurveyGeneral .= '<button type="submit">Create Subcategory</button>';
            $showSurveyGeneral .= '</form>';
            

        $showSurveyGeneral .= "<form action='/addSubcatArea'>";
        $showSurveyGeneral .= csrf_field();
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
                $showSurveyGeneral .= "<br>";
                
                
                $showSurveyGeneral .= '<div style="display: none;" id="numericQuestionSelect" value="">';
                $showSurveyGeneral .= 'Write a question to add: <input type="text" name="question"> <br>';
                $showSurveyGeneral .= '<span id="weight">Weight: <input type="number" name="weight"></span><br>';

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

            $showSurveyGeneral .= "</div>";

            //End Button Questions
            ///////////////

            //Survey Structure
            if($surveyAreas->count() == 0) {
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
                            $showSurveyGeneral .= "&nbsp;&nbsp;<strong>".$subcatArea->description."</strong><br>";
                        }
                    }
                }
                $showSurveyGeneral .= "</ul>";
            }
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
