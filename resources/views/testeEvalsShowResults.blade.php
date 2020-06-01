<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/041a9ee086.js" crossorigin="anonymous"></script>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>




    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<h2>{{$surveyName}}</h2>
<h4>{{$surveyType->description}}</h4>

@if($surveyType->id == 1)
    <h5>This is {{$userSelected->name}}'s self evaluation.</h5>
@else
<h5>This is {{$willEvaluateNameUser}}'s evaluation by {{$userSelected->name}}.</h5>
@endif
<br>



<button onclick="hideAvgPPArea()">Total Performance/Potential Area</button>
<button onclick="finalResults()">Final Results</button>
<button onclick="graph()">Graph</button>

<div id="avgPPArea" style="display: none">

    @if(count($areasHTML) == 0)
        <br>
        There are no areas in this survey yet!
    @else
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
                                                <table>
                                                    <tr>
                                                        <th>Score:</th>
                                                        @for($e = 0; $e < count($arrayQuestSurvey); $e++)
                                                            @if($questionsNumericHTML[$c+1]->id == $arrayQuestSurvey[$e]->idQuestion)
                                                                <td>{{$answersUserSurvey[$e]->value}}</td> <!-- Respostas -->
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        <th>Rating Scale:</th>
                                                        <td>&nbsp;&nbsp;{{$surveyAnswerLimit}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Weight:</th>
                                                        @for($g = 0; $g < count($totalAllQuestions); $g++)
                                                            @if($questionsNumericHTML[$c+1]->id == $totalAllQuestions[$g]->id)
                                                                <td>{{$totalPercentagesAllQuestions[$g]}}%</td> <!-- Pesos -->
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                </table>
                                            @else
                                                &nbsp;&nbsp;&nbsp;&nbsp;<li>{{$questionsNumericHTML[$c+1]->description}}</li>
                                                <table>
                                                    <tr>
                                                        <th>Score:</th>
                                                        @for($f = 0; $f < count($arrayQuestSurvey); $f++)
                                                            @if($questionsNumericHTML[$c+1]->id == $arrayQuestSurvey[$f]->idQuestion)
                                                                <td>{{$answersUserSurvey[$f]->value}}</td> <!-- Respostas -->
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                    <tr>
                                                        <th>Rating Scale:</th>
                                                        <td>&nbsp;&nbsp;{{$surveyAnswerLimit}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Weight:</th>
                                                        @for($h = 0; $h < count($totalAllQuestions); $h++)
                                                            @if($questionsNumericHTML[$c+1]->id == $totalAllQuestions[$h]->id)
                                                                <td>{{$totalPercentagesAllQuestions[$h]}}%</td> <!-- Pesos -->
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                </table>
                                            @endif
                                        @endif

                                    @endif
                                @endfor
                            </ol>
                        @endif
                    @endif
                @endfor
                <br>
                <table>
                    <tr>
                        <th>Total: </th>
                        @for($j = 0; $j < count($totalPercentageFinalAll); $j++)
                            @if($totalPercentageFinalAll[$j] == $areasHTML[$i]->id)
                                <td>&nbsp;&nbsp;{{$totalPercentageFinalAll[$j+1]}}%</td> <!-- Total Percentagem -->
                            @endif
                        @endfor
                    </tr>
                    <tr>
                        <th>Total Performance: </th>
                        @for($k = 0; $k < count($totalPercentagePerformanceFinal); $k++)
                            @if($totalPercentagePerformanceFinal[$k] == $areasHTML[$i]->id)
                                <td>&nbsp;&nbsp;{{$totalPercentagePerformanceFinal[$k+1]}}%</td> <!-- Total Percentagem -->

                            @endif
                        @endfor

                    </tr>
                    <tr>
                        <th>Total Potential: </th>
                        @for($l = 0; $l < count($totalPercentagePotentialFinal); $l++)
                            @if($totalPercentagePotentialFinal[$l] == $areasHTML[$i]->id)
                                <td>&nbsp;&nbsp;{{$totalPercentagePotentialFinal[$l+1]}}%</td> <!-- Total Percentagem -->

                            @endif
                        @endfor
                    </tr>
                </table>
                <br>
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
                        This area has no open questions!
                    @else
                    <li>{{$openQuestionsHTML[$d+1]->description}}</li>
                        @for($g = 0; $g < count($arrayQuestSurvey); $g++)
                            @if($openQuestionsHTML[$d+1]->id == $arrayQuestSurvey[$g]->idQuestion)
                                <textarea readonly>{{$answersUserSurvey[$g]->value}}</textarea> <!-- Respostas -->
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
<table>
    <tr>
        <th></th>
        <th>Total Performance</th>
        <th>Total Potential</th>
    </tr>

            @for($ç = 0; $ç < count($areasHTML); $ç++)
            <tr>
                <th>{{$areasHTML[$ç]->description}}</th>
                @for($v = 0; $v < count($totalNoPercentagePerformancePotential); $v++)
                    @if($areasHTML[$ç]->id == $totalNoPercentagePerformancePotential[$v])
                        <td>{{$totalNoPercentagePerformancePotential[$v+1]}}</td>
                        <td>{{$totalNoPercentagePerformancePotential[$v+2]}}</td>
                    @endif
                @endfor
            </tr>
            @endfor
            <tr>
                <th>Average Calculation</th>
                <th>{{$finalAvgPerformance}}</th>
                <th>{{$finalAvgPotential}}</th>
            </tr>
</table>

</div>

<div style="display: none" id="graph">

    <div id="myChart"></div>


</div>






<style>
#myChart {
    max-width: 900px;
    max-height: 900px;
}

</style>

<script>

    window.onload = function () {

var chart = new CanvasJS.Chart("myChart", {
	animationEnabled: true,
	title:{
		text: "Average Results Graph"
	},
	axisX: {
		title:"Potential",
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
