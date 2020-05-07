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
                    This area has no open questions!
                @else
                <li>{{$openQuestionsHTML[$d+1]->description}}</li>
                @endif
            @endif                   
        @endfor
        </ol>
    
@endforeach


</ul>

<br>





<!-- End Survey Structure -->

</body>
</html>
