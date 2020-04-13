<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\surveyType;
use App\Survey;
use App\Areas;
use App\AreasQuestConnect;
use App\subCategories;

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

        return redirect()->action('EvaluationsController@index')->with('survey', $msg);
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
       

        return redirect()->action('EvaluationsController@index')->with('subCatNewMsg', $subCatNewMsg);
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
                ->with('areaInSurvey', $areaInSurveyMsg);

        
 


        
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
        $idSurveyAndidArea = explode("and", $request->input('submitAreasPerSurveys'));
        $areaEQuestAll = AreasQuestConnect::All();
        AreasQuestConnect::where('idSurvey',  $idSurveyAndidArea[0])
        ->where('idArea', $idSurveyAndidArea[1])->first()->delete();

        $areaInSurveyMsg = "Area deleted successfully from survey!";

        return redirect()->action('EvaluationsController@index')
            ->with('areaInSurvey', $areaInSurveyMsg);

    }

    public function surveysSubcat(Request $request)
    {
        //
        $idSurveySelected = $request->input('idSurvey');
        $msg = "";

        if($idSurveySelected == 00) {
            $msg = "Choose a valid survey!";
        }
        else {
        $areaPerSurvey = Survey::find($idSurveySelected)->areas()->get();
        $subCats = subCategories::All();

        $msg .= "<strong>".Survey::find($idSurveySelected)->name."</strong>"."<br>";
        $msg .= "--------<br>";
        $msg .= "<strong>Add Subcategory to Area:</strong><br>";
        $msg .= "<form action='/addSubcatArea'>";
        $msg .= "<select name='selectedSubCat'>";
        $allSubCats = [];
                foreach($subCats as $subCat) {
                    if(!in_array($subCat->description, $allSubCats)) {
                        array_push($allSubCats, $subCat->description);
                        $msg .= "<option value=$subCat->id>".$subCat->description."</option>";
                    }
                   
                }
        $msg .= "</select>";
        $msg .= "<br>";
        $msg .= "<strong>to</strong><br>";
        $msg .= "<select name='selectedArea'>";
                    foreach($areaPerSurvey as $aps) {
        $msg .=           "<option value=$aps->id>".$aps->description."</option>";
                    }                
        $msg .= "</select>";
        $msg .= "<button>Add</button>";
        $msg .= "</form>";
        }

        return redirect()->action('EvaluationsController@index')
            ->with('areasPerSurveySubcat', $msg);

    }

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
            ->with('subCatAdd', $msg);



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
