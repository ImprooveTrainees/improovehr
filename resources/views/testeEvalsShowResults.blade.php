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

@section('content')

<div class="shadow p-1 bg-white cardbox111">
    <div class="surveyHeader">
        <h2>{{$surveyName}}</h2>
        <h4>{{$surveyType->description}}</h4>

        @if($surveyType->id == 1)
            <h5>This is {{$userSelected->name}}'s self evaluation.</h5>
        @else
        <h5>This is {{$willEvaluateNameUser}}'s evaluation by {{$userSelected->name}}.</h5>
        @endif
    </div>


    <div class="centerBtn">
        <button id="margTop" class="btn btn-info" onclick="hideAvgPPArea()">Total Performance/Potential Area</button>
        <button id="margTop" class="btn btn-info" onclick="finalResults()">Final Results</button>
        <button id="margTop" class="btn btn-info" onclick="graph()">Graph</button>
    </div>

    <div id="avgPPArea" style="display: none">

        @if(count($areasHTML) == 0)

            <h3 class="emptyForm"> <strong>There are no areas in this survey yet!</strong></h3>
        @else
        <ul>
            <div class="numQuestions2">
                @for($i = 0; $i < count($areasHTML); $i++)
                    <li class="areaLi2">
                        <label id="areaLabel2" for="">{{$areasHTML[$i]->description}}</label>
                    </li>
                        @for($b = 0; $b < count($subCatsHTML); $b+=2)
                            @if($subCatsHTML[$b]->id == $areasHTML[$i]->id)
                                @if($subCatsHTML[$b+1] == '0')
                                    <p class="emptySpace2"> <strong>This area has no subcategories!</strong> </p>
                                @else
                                    &nbsp;&nbsp;
                                        <label class="subLi2" for="">{{$subCatsHTML[$b+1]->description}}</label>
                                    <ol>
                                        @for($c = 0; $c < count($questionsNumericHTML); $c+=2)
                                            @if($questionsNumericHTML[$c]->id == $subCatsHTML[$b+1]->id)
                                                @if($questionsNumericHTML[$c+1] == '0')
                                                    <p class="emptySpace2"><strong>This subcategory has no questions!</strong> </p>
                                                @else
                                                    @if($questionsNumericHTML[$c+1]->idPP == 2)
                                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                                        <li class="pontencialQuest2">
                                                            <label for=""><strong>{{$questionsNumericHTML[$c+1]->description}}</strong> </label>
                                                        </li>

                                                        <table  id="firstTable" class="table table-bordered">
                                                            <thead>
                                                              <tr >
                                                                <th scope="col"> <strong>Score:</strong> </th>
                                                                    @for($e = 0; $e < count($arrayQuestSurvey); $e++)
                                                                        @if($questionsNumericHTML[$c+1]->id == $arrayQuestSurvey[$e]->idQuestion)
                                                                            <td>
                                                                                <label for="">{{$answersUserSurvey[$e]->value}}</label>
                                                                            </td> <!-- Respostas -->
                                                                        @endif
                                                                    @endfor
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col"><strong>Rating Scale:</strong></th>
                                                                        <td>&nbsp;&nbsp;{{$surveyAnswerLimit}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="col"> <strong>Weight:</strong></th>
                                                                        @for($g = 0; $g < count($totalAllQuestions); $g++)
                                                                            @if($questionsNumericHTML[$c+1]->id == $totalAllQuestions[$g]->id)
                                                                                <td>{{$totalPercentagesAllQuestions[$g]}}%</td> <!-- Pesos -->
                                                                             @endif
                                                                        @endfor
                                                              </tr>
                                                            </thead>
                                                          </table>


                                                    @else
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<li class="performanceQuest2"> <strong>{{$questionsNumericHTML[$c+1]->description}} </strong></li>

                                                        <table id="firstTable" class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Score:</th>
                                                                        @for($f = 0; $f < count($arrayQuestSurvey); $f++)
                                                                            @if($questionsNumericHTML[$c+1]->id == $arrayQuestSurvey[$f]->idQuestion)
                                                                                <td>{{$answersUserSurvey[$f]->value}}</td> <!-- Respostas -->
                                                                            @endif
                                                                        @endfor
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Rating Scale:</th>
                                                                <td>&nbsp;&nbsp;{{$surveyAnswerLimit}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="col">Weight:</th>
                                                                    @for($h = 0; $h < count($totalAllQuestions); $h++)
                                                                        @if($questionsNumericHTML[$c+1]->id == $totalAllQuestions[$h]->id)
                                                                            <td>{{$totalPercentagesAllQuestions[$h]}}%</td> <!-- Pesos -->
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
                                @endif
                            @endif
                        @endfor
                    <div class="aligntable">

                        <table id="finalTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Total: </th>
                                        @for($j = 0; $j < count($totalPercentageFinalAll); $j++)
                                            @if($totalPercentageFinalAll[$j] == $areasHTML[$i]->id)
                                                <td>&nbsp;&nbsp;{{$totalPercentageFinalAll[$j+1]}}%</td> <!-- Total Percentagem -->
                                            @endif
                                        @endfor
                                </tr>
                                <tr>
                                    <th scope="col">Total Performance: </th>
                                        @for($k = 0; $k < count($totalPercentagePerformanceFinal); $k++)
                                            @if($totalPercentagePerformanceFinal[$k] == $areasHTML[$i]->id)
                                                <td>&nbsp;&nbsp;{{$totalPercentagePerformanceFinal[$k+1]}}%</td> <!-- Total Percentagem -->

                                            @endif
                                        @endfor

                                </tr>
                                <tr>
                                    <th scope="col">Total Potential: </th>
                                        @for($l = 0; $l < count($totalPercentagePotentialFinal); $l++)
                                            @if($totalPercentagePotentialFinal[$l] == $areasHTML[$i]->id)
                                                <td>&nbsp;&nbsp;{{$totalPercentagePotentialFinal[$l+1]}}%</td> <!-- Total Percentagem -->

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

    <h4 id="openClass2"><strong>Open ended questions:</strong></h4>
        <ul>
            @foreach($surveyAreas as $sAreasOpen)
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
            @endforeach
        </ul>
</div>


<div style="display: none" id="finalResults">
    <div class="table-responsive">
        <table id="tableFormat" class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th id="tableStyle" class="bg-dark" scope="col"><b>Total Performance</b></th>
                <th class="table-primary" scope="col"><b>Total Potencial</b></th>
            </tr>
            </thead>
            <tbody>
                @for($ç = 0; $ç < count($areasHTML); $ç++)
                    <tr>
                        <th scope="row">{{$areasHTML[$ç]->description}}</th>
                        @for($v = 0; $v < count($totalNoPercentagePerformancePotential); $v++)
                            @if($areasHTML[$ç]->id == $totalNoPercentagePerformancePotential[$v])
                                <td class="table-secondary">{{$totalNoPercentagePerformancePotential[$v+1]}}</td>
                                <td class="table-secondary">{{$totalNoPercentagePerformancePotential[$v+2]}}</td>
                            @endif
                        @endfor
                    </tr>
                    @endfor
                    <tr class="table-Success">
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
