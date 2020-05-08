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

<!-- Begin Survey Structure  -->

<h1>{{$surveyType->description}}</h1>
@if($surveyType->id == 1)
<h4>This is your periodic evaluation. Above you will find three main areas that will be evaluated regarding your performance in the last semester. Please answer with honesty and clarity.</h4>
@endif

<h5 style="color:red">Please rate the following sentences on a scale of 1 to {{$surveyAnswerLimit}}, where 1 represents "Poor" and {{$surveyAnswerLimit}} represents "Excellent".</h5>

<form action="/storeAnswers">
    <input type="hidden" value={{$selectedSurveyId}} name="selectedSurveyId">
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
                                                <input type="hidden" name="questions[]" value={{$questionsNumericHTML[$c+1]->id}}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;<li style='color:blue;'>{{$questionsNumericHTML[$c+1]->description}} <input required name="answers[]" placeholder="0-{{$surveyAnswerLimit}}" type="number" min="1" max={{$surveyAnswerLimit}}></li>
                                            @else
                                                <input type="hidden" name="questions[]" value={{$questionsNumericHTML[$c+1]->id}}>
                                                &nbsp;&nbsp;&nbsp;&nbsp;<li>{{$questionsNumericHTML[$c+1]->description}} <input required name="answers[]" placeholder="0-{{$surveyAnswerLimit}}" type="number" min="1" max={{$surveyAnswerLimit}}></li>
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
                    <input type="hidden" name="questions[]" value={{$openQuestionsHTML[$d+1]->id}}>
                    <textarea required name="answers[]" placeholder="Write your answer here" rows="4" cols="50"></textarea>
                    @endif
                @endif                   
            @endfor
            </ol>
    @endforeach
    </ul>
    <button>Submit Answers</button> 



</form>

<br>





<!-- End Survey Structure -->

</body>
</html>
