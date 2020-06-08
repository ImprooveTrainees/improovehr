@extends('layouts.template')

@section('title')
    Improove HR - Create Evaluation
@endsection

@section('sidebarCreateEvaluation')
active
@endsection

@section('openEvaluations')
open
@endsection

@section('content')

<div class="shadow p-1 bg-white cardbox0">

    <div class="firstbox">
        <h2>New Survey</h2>

        <form class="form group createsurveyform" action="/createSurvey">
            <div class="form-group surveyname">
            @csrf
                <label for="">Name:</label>
                <input class="form-control" type="text" name="surveyName">
            </div>
            <div class="form-group answerlimit">
                <label for="">Answer Limit</label>
                <input class="form-control" type="number" name="answerLimit">
            </div>
            <div class="form-group surveytype">
                <label for="">Survey Type</label>
                <select class="form-control" id="exampleFormControlSelect2" name="surveyType">
                    @foreach($surveyTypes as $type)
                        <option value={{$type->id}}>{{$type->description}}</option>
                    @endforeach
                </select>
            </div>
                <button type="submit" class="form-group btn btn-outline-success creatSurvey">Create Survey</button>
        </form>
            @if(session('survey'))
                <p>
                    <?php echo session('survey')  ?>
                </p>
            @endif
    </div>
    <hr class="hrStyle">
    <div class="ndbox">
        <h2>Show Survey:</h2>
        <div class="aligndiv">
            <form  class="form group showSurveyForm" id="showSurvey" action="/showSurvey">
                <div class="form-group showSurv">
                        <select class="edit-form-control"  id="surveyShowID" {{--id="exampleFormControlSelect2"--}} name="surveyShowID">
                            @foreach($surveys as $survey)
                                <option selected value={{$survey->id}}>{{$survey->name}}</option>
                            @endforeach
                        </select>
                </div>
                    <button class="form-group btn btn-outline-success showSurvey">Show</button>
            </form>
        </div>
        @if($clickedShow == true)
        <div class="surveybox"> <!-- Inicio de div para radius a volta do questinario -->
            <b><h4>{{$surveyName}}</h4></b>
            <b><h4>{{$surveyType}}</h4></b>
            <div class="alignbtn">

                <button type='button' onclick='hideArea()' class="btn btn-info multiColor"><b> Add  / Remove Areas  </b></button>
                <button type='button' onclick='hideSubcat()' class="btn btn-info multiColor"><b>  Add  /  Remove Subcategories  </b></button>
                <button type='button' onclick='hideQuestions()' class="btn btn-info multiColor"><b>  Add  /  Remove Questions  </b></button>
                <button type='button' onclick='hideUserSurvey()' class="btn btn-info multiColor"><b>  Assign  /  Remove Users  </b></button>
            </div>

        <!-- //Button Area   -->
        <div style='display: none;' id='hideArea'>

            <div class="gridTop">

                    <form class="form group showSurveyForm2"  action="/createArea">
                        @csrf
                        <div class="form-group showSurv2">
                            <input class="form-control" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                            <label for="">New:</label>
                            <input class="form-control" type="text" name="newArea">
                            <button type="submit" class="btn btn-outline-success btncreate">Create Area</button>
                        </div>
                    </form>
            </div>
            <div class="grid">
                <form class="form group showSurveyForm2" action="/addAreaToSurvey">
                    @csrf
                    <div class="form-group showSurv2">
                            <input class="form-control" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                            <label for="">Add:</label>
                            <select class="form-control" id="exampleFormControlSelect2" name="areaSelect">
                                @for($i = 0; $i < count($allAreas); $i++)
                                    <option value={{$allAreasId[$i]}}>{{$allAreas[$i]}}</option>
                                @endfor
                            </select>
                            <select style="display: none;" name="idSurvey"> <!-- Escondido, só para enviar idsurvey-->
                                <option value={{$selectedSurveyId}}></option>';
                            </select>
                            <button class="btn btn-outline-success btncreate" name="submitArea" type="submit">Add</button>
                    </div>
                </form>
            </div>
            <div class="grid">
                <form class="form group showSurveyForm2" action="/deleteAreasSurvey">
                    @csrf
                    <div class="form-group showSurv2">
                        <input class="form-control" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                        @if($surveyAreas->count() == 0)
                            <label for="">There are no areas no remove!</label>
                        @else
                            <label for="">Remove:</label>
                            <select class="form-control" id="exampleFormControlSelect2" name='areaSurveyRemId'>
                            @foreach($surveyAreas as $sAreas)
                                <option value={{$sAreas->id}}and{{$selectedSurveyId}}>{{$sAreas->description}}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-outline-danger btncreate" type="submit">Remove Area</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <!-- //End Button Area   -->

<!-- //Begin Button Subcategory   -->

    <div style='display: none;' id='hideSubcat'>

            <form   class="form group showSurveyForm3" action="/newSubCat">
                @csrf
                <div class="form-group showSurv3">
                    <div class="testgrid3">
                        <input class="form-group" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                        <label for="">New:</label>
                        <input class="form-control" type="text" name="subCatNewName">
                        <button class="btn btn-outline-success" type="submit">Create Subcategory</button>
                    </div>
                </div>
            </form>
                <form class="form group showSurveyForm4" action='/addSubcatArea'>
                    @csrf
                    <div class="form-group showSurv4">
                        <div class="testgrid2">
                            <input class="form-group" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                            <label for="">Add: </label>
                            <select class="form-control" id="exampleFormControlSelect2" name='selectedSubCat'>
                                @for($i = 0; $i < count($allSubCats); $i++)
                                    <option value={{$allSubCatsId[$i]}}>{{$allSubCats[$i]}}</option>
                                @endfor
                                </select>
                                <strong>To</strong>
                            <select class="form-control" id="exampleFormControlSelect2" name='selectedArea'>
                                @foreach($surveyAreas as $aps)
                                    <option value={{$aps->id}}>{{$aps->description}}</option>
                                @endforeach
                            </select>
                                <button class="btn btn-outline-success">Add</button>
                        </div>
                    </div>
                </form>
            <form class="form group showSurveyForm5" action='/remSubcatArea'>
                @csrf
                <div class="form-group showSurv5">
                    <div class="testgrid33">
                        <input class="form-group" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                        <label for="">Remove:</label>
                        <select class="form-control" id="exampleFormControlSelect2" name='choosenAreaSubCatId'>
                            <?php echo $subCatsLoop ?>
                        </select>
                        <button class="btn btn-outline-danger" type='submit'>Remove</button>
                    </div>
                </div>
            </form>
    </div>


<!-- //End Button Subcategory   -->

<!-- //Begin Button Questions -->

<div style='display: none;' id='hideQuestions'>

    <form action="/newQuestion">
            <input type="hidden" id="questionTypeForm" name="questionTypeForm" value="">
            <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
        @csrf
        <div class="form-group showSurv6">
            <label  for="">Type: </label>
                @foreach($questionTypes as $type)
                    <label  >{{$type->description}}&nbsp;</label>
                        @if($type->description == "Open")
                            <input class="form-group" onchange="hideParam()"  id="openQuestion"  type="radio" name="questionType" value={{$type->id}}>
                        @else
                            <input class="form-group" onchange="hideParam()"  type="radio" name="questionType" value={{$type->id}}>
                        @endif
                @endforeach
        </div>

    <div style="display: none;" id="numericQuestionSelect" value="">
        <div class="form-group showSurv7">
            <div class="testgrid5">
                <label for="">Write a question to add:</label>
                <input class="form-control" type="text" name="question">
            </div>
                <span id="weight">
                    <div class="testgrid8">
                        <label for="">Weight:</label>
                        <input class="form-control" type="number" step="0.01" min="0" name="weight">
                        <b><label for="">%</label></b>
                    </div>
                </span>
{{---------------------------------------------- FALTA ALINHAR  ----------------------------------------------------------------------------------------------}}
                <div id="params">

                        <label for="">Parameters:</label>
                            @foreach($PPs as $pp)
                            <div class=" showSurv66">
                                <input class="" type="radio" name="PP" value={{$pp->id}}>
                                <label>{{$pp->description}}</label>&nbsp;
                            </div>
                            @endforeach

                </div>
{{---------------------------------------------- FALTA ALINHAR  ----------------------------------------------------------------------------------------------}}
            <div class="testgrid10">
                <label for="">Add:</label>
                <select class="form-control" id="exampleFormControlSelect2" name='choosenSubCatId'>
                    {{!!  $subCatsLoopQuestions !!}}
                </select>
                <button class="btn btn-outline-success btncreate" type='submit'>Add</button>
            </div>
        </div>
    </div>

    <div style="display: none;" id="openQuestionSelect">
        <div class="form-group showSurv8">
            <div class="testgrid5">
                <label class="" for="">Write a question to add:</label>
                <input  class="form-control" type="text" name="questionOpen">
            </div>
            <div class="testgrid6">
                <label for="">Add: </label>
                <select class="form-control" id="exampleFormControlSelect2" name='choosenAreaId'>
                    @foreach($surveyAreas as $area)
                            <option value={{$area->id}}>{{$area->description}}</option>
                    @endforeach
                </select>
                <button class="btn btn-outline-success btncreate " type='submit'>Add</button>
            </div>
        </div>
    </div>
</form>

    <form class="form-group" action="/remQuestion">
        <div class="form-group showSurv9">
            <div class="testgrid7">
                <label for="">Remove:</label>
                @csrf
                <input class="form-group" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                <select class="form-control" id="exampleFormControlSelect2" name="questionIdRemove">
                    {{!! $NumericQuestionsLoop !!}}
                    {{!!  $openQuestionsLoop !!}}
                </select>
                <button class="btn btn-outline-danger btncreate" type="submit">Remove</button>
            </div>
        </div>
    </form>

</div>




<!-- End Button Questions -->


<!-- Begin Button Users -->

<div style='display: none;' id='hideUserSurvey'>

    <form class="form-group showSurv7" action='/assignUser'>
        @csrf
        <input  type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
        <div class="aligment">
            <label for="">Assign Users to Survey:</label>
        </div>
            @foreach($users as $user)
                <div class="testgrid12">
                    <input type="checkbox" id={{$user->name}} name="users[]" value={{$user->id}}>
                    <label for={{$user->name}}>{{$user->name}}</label>
                        <select class="form-control" onchange="showEvaluatedChoice({{$user->id}})" id="evaluatedChoiceJS{{$user->id}}" name="evalChoice{{$user->id}}">
                            <!-- passamos o user id como argumento no select, para o JS nos mostrar o select correcto -->
                            <option value="1">...will be evaluated.</option>
                            <option value="0">...will evalue</option>
                        </select>

                    <select  class="form-control" style='display: none;' id='showEvaluatedSelection{{$user->id}}' name='evaluatorChoice{{$user->id}}'>
                        @foreach($users as $toBeEval)
                            <option value={{$toBeEval->id}}>{{$toBeEval->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        <div class="testgrid13">
            <label for="limitDate">Limit Date:</label>
            <input class="form-control" type="date" id="limitDate" name="limitDate">
            <button type='submit' class="btn btn-outline-success">Assign Users</button>
        </div>
    </form>

    <form action='/remUser'>
        @csrf
        <div class="testgrid14">
            <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
            <label for="">Remove:</label>
            @foreach($usersAssigned as $user)
                <input type="checkbox" id={{$user->name}} name="usersRem[]" value={{$user->id}}>
                <label for={{$user->name}}>{{$user->name}}</label>
            @endforeach
            <button type='submit' class="btn btn-outline-danger">Remove Users</button>
        </div>
      </form>


</div>

<!-- End Button Users -->

<!-- Begin Survey Structure  -->

    @if(count($areasHTML) == 0)

        <p><strong>There are no areas in this survey yet!</strong></p>
    @else
    <div class="topSurv">
        <ul>
            @for($i = 0; $i < count($areasHTML); $i++)
                <li><strong>{{$areasHTML[$i]->description}}</strong></li>
                    @for($b = 0; $b < count($subCatsHTML); $b+=2)
                        @if($subCatsHTML[$b]->id == $areasHTML[$i]->id)
                            @if($subCatsHTML[$b+1] == '0')
                                This area has no subcategories!
                            @else
                                &nbsp;&nbsp;<strong>{{$subCatsHTML[$b+1]->description}}</strong><br>
                                <ol>

                                    @for($c = 0; $c < count($questionsNumericHTML); $c+=2)
                                        @if($questionsNumericHTML[$c]->id == $subCatsHTML[$b+1]->id)
                                            @if($questionsNumericHTML[$c+1] == '0')
                                                This subcategory has no questions!
                                            @else

                                                @if($questionsNumericHTML[$c+1]->idPP == 2)
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<li style='color:blue;'>{{$questionsNumericHTML[$c+1]->description}}</li>
                                                @else
                                                    &nbsp;&nbsp;&nbsp;&nbsp;<li>{{$questionsNumericHTML[$c+1]->description}}</li>
                                                @endif
                                            @endif

                                        @endif
                                    @endfor
                                </ol>
                            @endif
                        @endif
                    @endfor
            @endfor
        </ul>
        @endif

        <strong>Open ended questions:</strong><br>
            <ul>
                @foreach($surveyAreas as $sAreasOpen)
                    <li><strong>{{$sAreasOpen->description}}</strong></li>
                        <ol>
                            @for($d = 0; $d < count($openQuestionsHTML); $d+=2)
                                @if($openQuestionsHTML[$d]->id == $sAreasOpen->id)
                                    @if($openQuestionsHTML[$d+1] == '0')
                                    <p><strong>This area has no open questions!</strong></p>
                                    @else
                                        <li>{{$openQuestionsHTML[$d+1]->description}}</li>
                                    @endif
                                @endif
                            @endfor
                        </ol>
                @endforeach
            </ul>
    </div>
    <div class="usersSurv">
        <h3><strong>Users assigned:</strong></h3><br>
            @if(count($usersEvaluatedHTML) == 0 && count($usersWillEvalueHTML) == 0)
                <p><strong>There are no users assigned to this survey!</strong></p>
            @else
            @foreach($usersEvaluatedHTML as $user)
                <h5><strong>{{$user}}</strong> will autoevaluate himself.</h5><br>
            @endforeach
            @foreach($usersWillEvalueHTML as $user => $otherUser)
                <h5><strong>{{$user}}</strong> will evaluate <strong>{{$otherUser}}</strong></h5><br>
            @endforeach
        @endif
    </div>
</div>
<!-- End Survey Structure -->


@endif



</div>

@if(session('msgError'))



    <?php echo session('msgError') ?>


@endif

</div>

@endsection

<script>
    console.log('teste');

function hideParam() {
    if(document.getElementById("openQuestion").checked == true) {
        document.getElementById("weight").style.display = "none";
        document.getElementById("numericQuestionSelect").style.display = "none";
        document.getElementById("openQuestionSelect").style.display = "block";
        document.getElementById("questionTypeForm").value = 2;

    }
    else {
        document.getElementById("weight").style.display = "block";
        document.getElementById("openQuestionSelect").style.display = "none";
        document.getElementById("numericQuestionSelect").style.display = "block";
        document.getElementById("questionTypeForm").value = 1;
    }

}

function hideArea() {
    if(document.getElementById("hideArea").style.display == "block") {
        document.getElementById("hideArea").style.display = "none";
    }
    else {
        document.getElementById("hideArea").style.display = "block";
        document.getElementById("hideSubcat").style.display = "none";
        document.getElementById("hideQuestions").style.display = "none";
        document.getElementById("hideUserSurvey").style.display = "none";

    }
}

function hideSubcat() {
    if(document.getElementById("hideSubcat").style.display == "block") {
        document.getElementById("hideSubcat").style.display = "none";

    }
    else {
        document.getElementById("hideSubcat").style.display = "block";
        document.getElementById("hideQuestions").style.display = "none";
        document.getElementById("hideUserSurvey").style.display = "none";
        document.getElementById("hideArea").style.display = "none";

    }
}

function hideQuestions() {
    if(document.getElementById("hideQuestions").style.display == "block") {
        document.getElementById("hideQuestions").style.display = "none";

    }
    else {
        document.getElementById("hideQuestions").style.display = "block";
        document.getElementById("hideSubcat").style.display = "none";
        document.getElementById("hideArea").style.display = "none";
        document.getElementById("hideUserSurvey").style.display = "none";

    }
}

function hideUserSurvey() {
    if(document.getElementById("hideUserSurvey").style.display == "block") {
        document.getElementById("hideUserSurvey").style.display = "none";

    }
    else {
        document.getElementById("hideUserSurvey").style.display = "block";
        document.getElementById("hideQuestions").style.display = "none";
        document.getElementById("hideSubcat").style.display = "none";
        document.getElementById("hideArea").style.display = "none";

    }
}

function showEvaluatedChoice(id) { //recebe o id do user, para mostrar o select do respectivo user
    if(document.getElementById('showEvaluatedSelection'+id).style.display == "none") {
        document.getElementById('showEvaluatedSelection'+id).style.display = "inline";
    }
    else {
        document.getElementById('showEvaluatedSelection'+id).style.display = "none";
    }

}





</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>

</body>
</html>
