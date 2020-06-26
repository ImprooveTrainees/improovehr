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

<style>
    /* Style the form */
#regForm {
  background-color: #ffffff;
  margin: 100px auto;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

/* Style the input fields */
input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

/* Mark the active step: */
.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #2a91b7;
}
</style>


@section('content')



<div class="shadow p-1 bg-white cardbox0">

    <div class="firstbox">

        <div class="container" id="settingstab">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#newSurvey">New Survey</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#showSurvey">Show Survey</a>
              </li>
            @if($clickedShow == true)
                <li class="nav-item" style="display: block;">
                    <a class="nav-link" data-toggle="tab" href="#areas">Add / Remove Areas</a>
                </li>
                <li class="nav-item" style="display: block;">
                    <a class="nav-link" data-toggle="tab" href="#subcats">Add / Remove SubCategories</a>
                </li>
                <li class="nav-item" style="display: block;">
                    <a class="nav-link" data-toggle="tab" href="#questions">Add / Remove Questions</a>
                </li>
                <li class="nav-item" style="display: block;">
                    <a class="nav-link" data-toggle="tab" href="#users">Add / Remove Users</a>
                </li>
                <li class="nav-item" style="display: block;">
                    <a class="nav-link" data-toggle="tab" href="#survey">Survey</a>
                </li>
            @else
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" data-toggle="tab" href="#areas">Add / Remove Areas</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" data-toggle="tab" href="#subcats">Add / Remove SubCategories</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" data-toggle="tab" href="#questions">Add / Remove Questions</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" data-toggle="tab" href="#users">Add / Remove Users</a>
                </li>
                <li class="nav-item" style="display: none;">
                    <a class="nav-link" data-toggle="tab" href="#survey">Survey</a>
                </li>
            @endif
            </ul>
<div class="tab-content">

    <div id="newSurvey" class="container tab-pane active">
        <p>New Survey</p>
        <hr>
        <form class="form group createsurveyform" action="/createSurvey">
            <div class="form-group surveyname">
                @csrf
                <label for="">Name:</label>
                <input class="form-control" type="text" name="surveyName">
            </div>
            <div class="form-group answerlimit">
                <label for="">Answer Limit:</label>
                <input class="form-control" type="number" name="answerLimit">
            </div>
            <div class="form-group surveytype">
                <label for="">Survey Type:</label>
                <select class="form-control" id="exampleFormControlSelect2" name="surveyType">
                    @foreach($surveyTypes as $type)
                        <option value={{$type->id}}>{{$type->description}}</option>
                    @endforeach
                </select>
                <button type="submit" class="form-group btn btn-outline-primary">Create Survey</button>
            </div>

        </form>
            @if(session('survey'))
                <p>
                    <?php echo session('survey')  ?>
                </p>
            @endif
    </div>
    <div id="showSurvey" class="container tab-pane fade showSurveytop">
        <p>Show Survey:</p>
        <hr>
        <div class="aligndiv">
            <form  class="form group showSurveyForm" id="showSurvey" action="/showSurvey">
                <div class="form-group showSurv11">
                        <label for="">Choose: </label>
                        <select class="edit-form-control"  id="surveyShowID" {{--id="exampleFormControlSelect2"--}} name="surveyShowID">
                            @foreach($surveys as $survey)
                                <option selected value={{$survey->id}}>{{$survey->name}}</option>
                            @endforeach
                        </select>
                        <button id="showSurvey" class="form-group btn btn-outline-primary">Show</button>
                </div>

            </form>
        </div>
    </div>
    @if($clickedShow == true)
    <!-- //Button Area   -->
    <div id="areas" class="container tab-pane fade showSurveytop">
        <p id="marginMobile">{{$surveyName}}</p>
        <p>{{$surveyType}}</p>
        <hr>
        <div class="gridTop">
                <form class="form group showSurveyForm2"  action="/createArea">
                    @csrf
                    <div class="form-group showSurv2">
                        <input class="form-control" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                        <label for="">New:</label>
                        <input class="form-control" type="text" name="newArea">
                        <button type="submit" class="btn btn-outline-primary">Create Area</button>
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
                        <button class="btn btn-outline-primary" name="submitArea" type="submit">Add</button>
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
                    <button class="btn btn-outline-primary" type="submit">Remove Area</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <!-- //End Button Area   -->
    <!-- //Begin Button Subcategory   -->

    <div id="subcats" class="container tab-pane fade showSurveytop">
        <p id="marginMobile">{{$surveyName}}</p>
        <p>{{$surveyType}}</p>
        <hr>
        <form   class="form group showSurveyForm3" action="/newSubCat">
            @csrf
            <div class="form-group showSurv3">
                <div class="testgrid3">
                    <input class="form-group" type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
                    <label for="">New:</label>
                    <input class="form-control" type="text" name="subCatNewName">
                    <button class="btn btn-outline-primary" type="submit">Create Subcategory</button>
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
                            <label id="strongGrid">To</label>
                        <select class="form-control marginSelect" id="exampleFormControlSelect2" name='selectedArea'>
                            @foreach($surveyAreas as $aps)
                                <option value={{$aps->id}}>{{$aps->description}}</option>
                            @endforeach
                        </select>
                            <button class="btn btn-outline-primary">Add</button>
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
                    <button class="btn btn-outline-primary" type='submit'>Remove</button>
                </div>
            </div>
        </form>
</div>
<!-- //End Button Subcategory   -->

<!-- //Begin Button Questions -->

<div id="questions" class="container tab-pane fade showSurveytop">
    <p id="marginMobile">{{$surveyName}}</p>
    <p>{{$surveyType}}</p>
    <hr>
    <form action="/newQuestion">
            <input type="hidden" id="questionTypeForm" name="questionTypeForm" value="">
            <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
        @csrf
        <div class="form-group showSurv6">
            <label  for="">Type: </label>
                @foreach($questionTypes as $type)
                    <label id="start2" >{{$type->description}}&nbsp;</label>
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
                        <input class="form-control" type="number" step="0.01" min="0" name="weight" placeholder="%">
                        <b><label for=""></label></b>
                    </div>
                </span>
                <div id="params">

                        <label for="">Parameters:</label>
                            @foreach($PPs as $pp)
                            <div class=" showSurv66">
                                <input class="" type="radio" name="PP" value={{$pp->id}}>
                                <label>{{$pp->description}}</label>&nbsp;
                            </div>
                            @endforeach

                </div>
            <div class="testgrid10">
                <label for="">Add:</label>
                <select class="form-control" id="exampleFormControlSelect2" name='choosenSubCatId'>
                    {{!!  $subCatsLoopQuestions !!}}
                </select>
                <button class="btn btn-outline-primary btncreate" type='submit'>Add</button>
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
                <button class="btn btn-outline-primary btncreate " type='submit'>Add</button>
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
                <button class="btn btn-outline-primary btncreate" type="submit">Remove</button>
            </div>
        </div>
    </form>

</div>
<!-- End Button Questions -->
<!-- Begin Button Users -->

<div id="users" class="container tab-pane fade showSurveytop">
    <p id="marginMobile">{{$surveyName}}</p>
    <p>{{$surveyType}}</p>
    <hr>
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

                    <select  class="form-control secondSelect" style='display: none;' id='showEvaluatedSelection{{$user->id}}' name='evaluatorChoice{{$user->id}}'>
                        @foreach($users as $toBeEval)
                            <option value={{$toBeEval->id}}>{{$toBeEval->name}}</option>
                        @endforeach
                    </select>
                </div>
            @endforeach
        <div class="testgrid13">
            <label for="limitDate">Limit Date:</label>
            <input class="form-control" type="date" id="limitDate" name="limitDate">
            <button type='submit' class="btn btn-outline-primary">Assign Users</button>
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
            <button type='submit' class="btn btn-outline-primary">Remove Users</button>
        </div>
      </form>


</div>
<div id="survey" class="container tab-pane fade showSurveytop">

    <div class="ndbox">

        @if($clickedShow == true)
        <div class=""> <!-- Inicio de div para radius a volta do questinario -->
            <p id="marginMobile">{{$surveyName}}</p>
            <p>{{$surveyType}}</p>
            <hr>
            <ul class="survey">
                @for($i = 0; $i < count($areasHTML); $i++)
                    {{-- <strong>{{$areasHTML[$i]->description}}</strong> --}}
                        @for($b = 0; $b < count($subCatsHTML); $b+=2)
                            @if($subCatsHTML[$b]->id == $areasHTML[$i]->id)
                            <div class="tab">
                                @if($subCatsHTML[$b+1] == '0')
                                    This area has no subcategories!
                                @else
                                        <strong>{{$areasHTML[$i]->description}}</strong>
                                        <br>
                                    &nbsp;&nbsp;<strong>{{$subCatsHTML[$b+1]->description}}</strong>
                                    <ol>

                                        @for($c = 0; $c <count($questionsNumericHTML); $c+=2)
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
                                </div>
                                @endif
                            @endif
                        @endfor
                @endfor
            </ul>
            <ul class="survey">
                @foreach($surveyAreas as $sAreasOpen)
                <div class="tab">
                    <strong>Open ended questions:</strong><br>
                    <strong>{{$sAreasOpen->description}}</strong>
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
                    </div>
                @endforeach
            </ul>
            <div style="overflow:auto;">
                <div style="float:right;">
                  <button class="btn btn-outline-primary" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                  <button class="btn btn-outline-primary" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
              </div>
            @for($k = 0; $k < count($subCatsHTML); $k++)
            <div style="float: left; margin-top:10px">
                <span class="step">
            </div>
            @endfor

<!-- Begin Survey Structure  -->
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



</div>
@endif
<!-- End Button Users -->


    </div>
    {{-- <hr class="hrStyle"> --}}


@if(session('msgError'))



    <?php echo session('msgError') ?>


@endif

</div>

<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Close";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>

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

