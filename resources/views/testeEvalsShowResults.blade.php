@extends('layouts.template')

@section('title')
    Improove HR - Surveys Results
@endsection

@section('openEvaluations')
active
@endsection

@section('Results')
    open
    @section('showOther')
        open
    @endsection
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

<div class="shadow p-1 bg-white cardbox111">
    <div class="surveyHeader">
        <h2 style="color: rgba(128, 128, 128, 0.692);"> {{$surveyName}}</h2>
        <h4 style="color: rgba(128, 128, 128, 0.692);">{{$surveyType->description}}</h4>

        @if($surveyType->id == 1)
            <h5>This is {{$userSelected->name}}'s self evaluation.</h5>
        @else
        <h5 style="color: rgba(128, 128, 128, 0.692);">This is {{$willEvaluateNameUser}}'s evaluation by {{$userSelected->name}}.</h5>
        @endif
    </div>


    <div class="centerBtn">
        <button id="margTop" class="btn btn-outline-primary bprofile" onclick="hideAvgPPArea()">Total Performance/Potential Area</button>
        <button id="margTop" class="btn btn-outline-primary bprofile" onclick="finalResults()">Final Results</button>
        <button id="margTop" class="btn btn-outline-primary bprofile" onclick="graph()">Graph</button>
    </div>

    <div id="avgPPArea" style="display: none">

        @if(count($areasHTML) == 0)

            <h3 class="emptyForm"> <strong>There are no areas in this survey yet!</strong></h3>
        @else
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
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <li class="pontencialQuest2">
                                                            <label for=""><strong>{{$questionsNumericHTML[$c+1]->description}}</strong> </label>
                                                        </li>

                                                        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" style="width: 20%">
                                                            <thead class="thead-dark">
                                                              <tr >
                                                                <th class="d-none d-sm-table-cell" style="width: 5%;"> <strong>Score:</strong> </th>
                                                                    @for($e = 0; $e < count($arrayQuestSurvey); $e++)
                                                                        @if($questionsNumericHTML[$c+1]->id == $arrayQuestSurvey[$e]->idQuestion)
                                                                            <td style="width: 5%;">
                                                                                <label for="">{{$answersUserSurvey[$e]->value}}</label>
                                                                            </td> <!-- Respostas -->
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                                <tr>
                                                                    <th class="d-none d-sm-table-cell" style="width: 5%;"><strong>Rating Scale:</strong></th>
                                                                        <td style="width: 5%;">&nbsp;&nbsp;{{$surveyAnswerLimit}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="d-none d-sm-table-cell" style="width: 5%;"> <strong>Weight:</strong></th>
                                                                        @for($g = 0; $g < count($totalAllQuestions); $g++)
                                                                            @if($questionsNumericHTML[$c+1]->id == $totalAllQuestions[$g]->id)
                                                                                <td style="width: 5%;">{{$totalPercentagesAllQuestions[$g]}}%</td> <!-- Pesos -->
                                                                             @endif
                                                                        @endfor
                                                              </tr>
                                                            </thead>
                                                          </table>


                                                    @else
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<li class="performanceQuest2"> <strong>{{$questionsNumericHTML[$c+1]->description}} </strong></li>

                                                        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" style="width: 20%">
                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th class="d-none d-sm-table-cell" style="width: 5%;">Score:</th>
                                                                        @for($f = 0; $f < count($arrayQuestSurvey); $f++)
                                                                            @if($questionsNumericHTML[$c+1]->id == $arrayQuestSurvey[$f]->idQuestion)
                                                                                <td style="width: 5%;">{{$answersUserSurvey[$f]->value}}</td> <!-- Respostas -->
                                                                            @endif
                                                                        @endfor
                                                            </tr>
                                                            <tr>
                                                                <th class="d-none d-sm-table-cell" style="width: 5%;">Rating Scale:</th>
                                                                <td style="width: 5%;">&nbsp;&nbsp;{{$surveyAnswerLimit}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="d-none d-sm-table-cell" style="width: 5%;">Weight:</th>
                                                                    @for($h = 0; $h < count($totalAllQuestions); $h++)
                                                                        @if($questionsNumericHTML[$c+1]->id == $totalAllQuestions[$h]->id)
                                                                            <td style="width: 5%;">{{$totalPercentagesAllQuestions[$h]}}%</td> <!-- Pesos -->
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                            </thead>
                                                        </table>

                                                    @endif
                                                @endif
                                            @endif
                                        @endfor
                                    </ol>
                                </div>
                                @endif
                            @endif
                        @endfor
                    <div class="aligntable">

                        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" style="width: 20%">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="d-none d-sm-table-cell" style="width: 5%;">Total: </th>
                                        @for($j = 0; $j < count($totalPercentageFinalAll); $j++)
                                            @if($totalPercentageFinalAll[$j] == $areasHTML[$i]->id)
                                                <td style="width: 5%;">&nbsp;&nbsp;{{$totalPercentageFinalAll[$j+1]}}%</td> <!-- Total Percentagem -->
                                            @endif
                                        @endfor
                                </tr>
                                <tr>
                                    <th class="d-none d-sm-table-cell" style="width: 5%;">Total Performance: </th>
                                        @for($k = 0; $k < count($totalPercentagePerformanceFinal); $k++)
                                            @if($totalPercentagePerformanceFinal[$k] == $areasHTML[$i]->id)
                                                <td style="width: 5%;">&nbsp;&nbsp;{{$totalPercentagePerformanceFinal[$k+1]}}%</td> <!-- Total Percentagem -->

                                            @endif
                                        @endfor

                                </tr>
                                <tr>
                                    <th class="d-none d-sm-table-cell" style="width: 5%;">Total Potential: </th>
                                        @for($l = 0; $l < count($totalPercentagePotentialFinal); $l++)
                                            @if($totalPercentagePotentialFinal[$l] == $areasHTML[$i]->id)
                                                <td style="width: 5%;">&nbsp;&nbsp;{{$totalPercentagePotentialFinal[$l+1]}}%</td> <!-- Total Percentagem -->

                                            @endif
                                        @endfor
                                </tr>
                            </thead>
                        </table>

                    </div>
                @endfor
            </div>
        </ul>


        @endif


        <ul>
            @foreach($surveyAreas as $sAreasOpen)
            <div class="tab">
                <h4 id="openClass2"><strong>Open ended questions:</strong></h4>
                <li class="areaLi2"><label id="areaLabel2" for=""><strong>{{$sAreasOpen->description}}</strong></label></li>
                    <ol>
                    @for($d = 0; $d < count($openQuestionsHTML); $d+=2)
                        @if($openQuestionsHTML[$d]->id == $sAreasOpen->id)
                            @if($openQuestionsHTML[$d+1] == '0')
                                <p class="emptySpace2"> <strong>This area has no open questions!</strong> </p>
                            @else
                            <li class="openLi2">
                                <label class="performanceQuest2" for="">{{$openQuestionsHTML[$d+1]->description}}</label> </li>
                                @for($g = 0; $g < count($arrayQuestSurvey); $g++)
                                    @if($openQuestionsHTML[$d+1]->id == $arrayQuestSurvey[$g]->idQuestion)
                                        <textarea class="form-control" readonly>{{$answersUserSurvey[$g]->value}}</textarea> <!-- Respostas -->
                                    @endif
                                @endfor
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
</div>


<div style="display: none" id="finalResults">
    <div class="">
        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" >
            <thead class="thead-dark">
            <tr>
                <th class="d-none d-sm-table-cell" style="width: 5%;">#</th>
                <th class="d-none d-sm-table-cell" style="width: 5%;"><b>Total Performance</b></th>
                <th class="d-none d-sm-table-cell" style="width: 5%;"><b>Total Potencial</b></th>
            </tr>
            </thead>
            <tbody>
                @for($ç = 0; $ç < count($areasHTML); $ç++)
                    <tr>
                        <th scope="row">{{$areasHTML[$ç]->description}}</th>
                        @for($v = 0; $v < count($totalNoPercentagePerformancePotential); $v++)
                            @if($areasHTML[$ç]->id == $totalNoPercentagePerformancePotential[$v])
                                <td class="">{{$totalNoPercentagePerformancePotential[$v+1]}}</td>
                                <td class="">{{$totalNoPercentagePerformancePotential[$v+2]}}</td>
                            @endif
                        @endfor
                    </tr>
                    @endfor
                    <tr class="">
                        <th class="" scope="row">Average Calculation</th>
                        <td class=""><b>{{$finalAvgPerformance}}</b></td>
                        <td class=""><b>{{$finalAvgPotential}}</b></td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>

<div  style="display: none" id="graph">

    <div id="myChart"  {{-- class="chartStyle"--}}>

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

@endsection

<style>

    </style>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script>

        window.onload = function () {

    var chart = new CanvasJS.Chart("myChart", {
        animationEnabled: true,
        title:{
            fontColor: "#a7b530",
            fontFamily: "Helvetica",
            horizontalAlign: "center",
            text: "Average Results Graph"
        },
        axisX: {
            title:"Potential",
            titleFontColor: "blue",
            minimum: 0,
            maximum: 6,
            interval: 2,
          gridThickness: 1
        },
        axisY:{
            title: "Performance",
              minimum: 0,
              maximum: 6,
            interval: 2,
              gridThickness: 1
        },
        data: [{
            type: "scatter",
            toolTipContent: "<span style=\"color:#4F81BC \"><b>{name}</b></span><br/><b> Potential:</b> {x} <br/><b> Performance:</b></span> {y}",
            name: "Result",
            showInLegend: true,
            dataPoints: [
                { x: {{$finalAvgPotential}}, y: {{$finalAvgPerformance}} },
            ]
        }]

    });
        chart.render();
    }

    function hideAvgPPArea() {
        if(document.getElementById("avgPPArea").style.display == "block") {
            document.getElementById("avgPPArea").style.display = "none";

        }
        else {
            document.getElementById("avgPPArea").style.display = "block";

        }
    }

    function finalResults() {
        if(document.getElementById("finalResults").style.display == "block") {
            document.getElementById("finalResults").style.display = "none";

        }
        else {
            document.getElementById("finalResults").style.display = "block";

        }
    }

    function graph() {
        if(document.getElementById("graph").style.display == "block") {
            document.getElementById("graph").style.display = "none";

        }
        else {
            document.getElementById("graph").style.display = "block";

        }
    }


    </script>

</body>
</html>
