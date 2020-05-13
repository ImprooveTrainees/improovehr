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
<h5>This is {{$willEvaluateNameUser->name}}'s evaluation by {{$userSelected->name}}.</h5>
@endif
<br>



<button onclick="hideAvgPPArea()">Average Perf/Poten Area</button>

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
                                                </table>
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

<script>
    
function hideAvgPPArea() {
    if(document.getElementById("avgPPArea").style.display == "block") {
        document.getElementById("avgPPArea").style.display = "none";
        
    }
    else {
        document.getElementById("avgPPArea").style.display = "block";
        
    }
}


</script>


</body>
</html>
