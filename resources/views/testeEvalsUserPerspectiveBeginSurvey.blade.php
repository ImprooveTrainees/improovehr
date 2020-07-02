@extends('layouts.template')

@section('title')
    Improove HR - Survey
@endsection

@section('sidebarCompleteSurvey')
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

<div class="shadow p-1 bg-white cardbox11">

    <div class="container" id="settingstab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#instSurvey">Survey Instructions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#Survey">Survey</a>
          </li>
        </ul>

        <div class="tab-content">

            <div id="instSurvey" class="container tab-pane active">
                <div class="surveyHeader">
                    <h2 style="color: rgba(128, 128, 128, 0.692);">{{$surveyType->description}}</h2>
                        @if($surveyType->id == 1)
                            <h4 style="color: rgba(128, 128, 128, 0.692);">This is your periodic evaluation. Above you will find {{count($areasHTML)}} main areas that will be evaluated regarding your performance in the last semester. Please answer with honesty and clarity.</h4>
                        @else
                            <h4 style="color: rgba(128, 128, 128, 0.692);">This is {{$willEvaluateNameUser}}'s periodic evaluation. Above you will find {{count($areasHTML)}} main areas that will be evaluated regarding {{$willEvaluateNameUser}}'s performance in the last semester. Please answer with honesty and clarity.</h4>
                        @endif

                    <h5 style="color: rgba(128, 128, 128, 0.692);">Please rate the following sentences on a scale of 1 to {{$surveyAnswerLimit}}, where 1 represents "Poor" and {{$surveyAnswerLimit}} represents "Excellent".</h5>
                </div>
            </div>

            <div id="Survey" class="container tab-pane fade">
                <!-- Begin Survey Structure  -->
                <form action="/storeAnswers">
                    <input type="hidden" value={{$selectedSurveyId}} name="selectedSurveyId">
                    @if(count($areasHTML) == 0)
                        <br>
                        There are no areas in this survey yet!
                    @else
                    <ul class="survey" style="margin-top:25px">
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
                                                                {{-- &nbsp;&nbsp;&nbsp;&nbsp;<li style='color:blue;'>{{$questionsNumericHTML[$c+1]->description}}</li> --}}
                                                                <input type="hidden" name="questions[]" value={{$questionsNumericHTML[$c+1]->id}}>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <li class="pontencialQuest">
                                                                            <label>{{$questionsNumericHTML[$c+1]->description}}</label>
                                                                            <input id="size" class="form-control" required name="answers[]" placeholder="0-{{$surveyAnswerLimit}}" type="number" min="1" max={{$surveyAnswerLimit}}>
                                                                        </li>
                                                            @else
                                                                {{-- &nbsp;&nbsp;&nbsp;&nbsp;<li>{{$questionsNumericHTML[$c+1]->description}}</li> --}}
                                                                <input type="hidden" name="questions[]" value={{$questionsNumericHTML[$c+1]->id}}>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                <li class="">
                                                                    <label>{{$questionsNumericHTML[$c+1]->description}}</label>
                                                                    <input id="size" class="form-control" required name="answers[]" placeholder="0-{{$surveyAnswerLimit}}" type="number" min="1" max={{$surveyAnswerLimit}}>
                                                                </li>
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
                                            <li id="">
                                                <label for="">{{$openQuestionsHTML[$d+1]->description}}</label>
                                            </li>
                                            <input class="form-control" type="hidden" name="questions[]" value={{$openQuestionsHTML[$d+1]->id}} >
                                            <textarea id="areaText" class="form-control" required name="answers[]" placeholder="Write your answer here" rows="4" cols="50"></textarea>
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
                    <div style="float: left; margin-top:10px; text-align:center">
                        <span class="step">
                    </div>
                    @endfor

                    @endif
                        {{-- <div id="surveyBtn">
                            <button class="btn btn-success btn-lg" onclick="sweetalert()">Submit Answers</button>
                        </div> --}}
                </form>
                <!-- End Survey Structure -->
            </div>


        </div>




    </div>



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
    document.getElementById("nextBtn").innerHTML = "Submit Answers";
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

</body>
<script>
    sweetalert(){
            Swal.fire(
                'Good job!',
                'You have succesfully submited your survey!',
                'success'
                )
    }


</script>
</html>
