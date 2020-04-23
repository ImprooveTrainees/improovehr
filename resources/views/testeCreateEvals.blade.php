<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- @extends('layouts.template') --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
{{-- @section('content') --}}

    <h3>New Survey</h3>
    <br>

<form action="/createSurvey">
    @csrf
    Name: <input type="text" name="surveyName">
    <br>
    Answer Limit: <input type="number" name="answerLimit">
    <br>
    Survey Type:
    
    <select name="surveyType">
        @foreach($surveyTypes as $type)
            <option value={{$type->id}}>{{$type->description}}</option>
        @endforeach
    </select>
    <br>
    <button type="submit">Create Survey</button>
</form>
@if(session('survey'))
    <p>
        <?php echo session('survey')  ?>
    </p>
@endif
---------------------------------

<div>
    <h3>Show Survey:</h3>
<form id="showSurvey" action="/showSurvey">
    <select id="surveyShowID" name="surveyShowID">
        @foreach($surveys as $survey)
            <option selected value={{$survey->id}}>{{$survey->name}}</option>
        @endforeach
    </select>
    <button>Show</button>  
</form>
<br>


@if($clickedShow == true)
<h4>{{$surveyName}}</h4>
<h4>{{$surveyType}}</h4>
    <button type='button' onclick='hideArea()'>Add/Remove Areas</button>
    <button type='button' onclick='hideSubcat()'>Add/Remove Subcategories</button>
    <button type='button' onclick='hideQuestions()'>Add/Remove Questions</button>
    <button type='button' onclick='hideUserSurvey()'>Assign/Remove Users</button>

    <!-- //Button Area   -->
    <div style='display: none;' id='hideArea'>

        <form action="/createArea">
        @csrf
        <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
        New: <input type="text" name="newArea">
        <button type="submit">Create Area</button>

        </form>

        <form action="/addAreaToSurvey">
        @csrf
        <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
        Add: <select name="areaSelect">  
        
            @for($i = 0; $i < count($allAreas); $i++)
                <option value={{$allAreasId[$i]}}>{{$allAreas[$i]}}</option>   
            @endfor

        </select>

        <select style="display: none;" name="idSurvey"> <!-- Escondido, só para enviar idsurvey-->
           <option value={{$selectedSurveyId}}></option>';               
        </select>

        <button name="submitArea" type="submit">Add</button>

         </form>
        
        <form action="/deleteAreasSurvey">
            @csrf
        <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
        @if($surveyAreas->count() == 0) 
            There are no areas no remove!
        
        @else 
            Remove: <select name='areaSurveyRemId'>
            @foreach($surveyAreas as $sAreas) 
                <option value={{$sAreas->id}}and{{$selectedSurveyId}}>{{$sAreas->description}}</option>
            @endforeach
        
    
        </select>
        <button type="submit">Remove Area</button>
        @endif
        </form>

        </div>
        <!-- //End Button Area   -->

<!-- //Begin Button Subcategory   -->

<!-- //End Button Subcategory   -->


@endif







</div>

@if(session('msgError'))
    <p>
        <?php echo session('msgError')  ?>
    </p>
@endif


{{-- @endsection --}}




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
        
    }
}

function hideSubcat() {
    if(document.getElementById("hideSubcat").style.display == "block") {
        document.getElementById("hideSubcat").style.display = "none";
        
    }
    else {
        document.getElementById("hideSubcat").style.display = "block";
        
    }
}

function hideQuestions() {
    if(document.getElementById("hideQuestions").style.display == "block") {
        document.getElementById("hideQuestions").style.display = "none";
        
    }
    else {
        document.getElementById("hideQuestions").style.display = "block";
        
    }
}

function hideUserSurvey() {
    if(document.getElementById("hideUserSurvey").style.display == "block") {
        document.getElementById("hideUserSurvey").style.display = "none";
        
    }
    else {
        document.getElementById("hideUserSurvey").style.display = "block";
        
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

    
</body>
</html>
