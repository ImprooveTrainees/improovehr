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
    crossorigin="anonymous">
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

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



{{-- <br>
<h3>Areas:</h3> --}}
{{-- <form action="/createArea">
    @csrf
    New: <input type="text" name="newArea">
    <button type="submit">Create Area</button>
</form> --}}

{{-- <form action="/addAreaToSurvey"> 
<br>
<strong>Add Area to Survey:</strong>
<br>
<select name="areaSelect">
<?php   
    // $allAreas = [];        
?>
    @foreach($areas as $area) 
    <!-- Tendo em conta que vão ser sempre criadas novas áreas para 
        depois serem atribuidas ao Survey, e a novas subCats, esta lista só irá mostrar nomes
        das áreas, nunca repetindo o mesmo nome. Ao adicionar uma área a um survey, o que na verdade
        faz é criar uma nova área com o nome da área seleccionada/já existente.
      -->
        @if(!in_array($area->description, $allAreas))
            {{array_push($allAreas, $area->description)}}
            <option value={{$area->id}}>{{$area->description}}</option>
        @endif      
    @endforeach
</select>
<br>
<strong>to</strong>
<br>
<select name="idSurvey">
    @foreach($surveys as $survey)
        <option value={{$survey->id}}>{{$survey->name}}</option>
    @endforeach
</select>
<button name="submitArea" type="submit">Add</button>



</form> --}}


{{-- @if(session('areaInSurvey'))
    <p>
        <?php //echo session('areaInSurvey')  ?>
    </p>
@endif

<br>
<br> --}}

{{-- <form action="/areasPerSurveys">
Areas per survey:
<select name="idSurvey">
@foreach($surveys as $survey)
    <option value={{$survey->id}}>{{$survey->name}}</option>
@endforeach
</select>
<button type="submit">Show</button>
</form>

<form action="/deleteAreasSurvey">
    @if(session('areasPerSurvey'))
    <p>
         <?php //echo session('areasPerSurvey')  ?> 
    </p>
@endif
</form> --}}

---------------------------------
{{-- <h3>Subcategories:</h3> --}}

{{-- <form action="/newSubCat">
New:<input name="subCatNewName">
<button type="submit">Create Subcategory</button>
</form> --}}

{{-- @if(session('subCatNewMsg'))
    <p>
        <?php //echo session('subCatNewMsg')  ?>
    </p>
@endif
<br>
Choose a survey:
<form id="surveySubCat" action="/surveysSubcat">
    <select onchange="execFormSubcat()" name="idSurvey">
        <option value="00">---</option>
    @foreach($surveys as $survey)
        <option value={{$survey->id}}>{{$survey->name}}</option>
    @endforeach
</select>
</form>
<br>
@if(session('areasPerSurveySubcat'))
        <?php //echo session('areasPerSurveySubcat')  ?>
@endif

@if(session('subCatAdd'))
        <?php //echo session('subCatAdd')  ?>
@endif


<br> --}}
---------------------------------
{{-- <br>
<h3>Questions</h3>
<form action="/newQuestion">
    @csrf
    Type: <br>
    <label>Numeric</label>
    <input onchange="hideParam()" type="radio" name="questionType" value="Numeric">
    <label>Open</label>
    <input onchange="hideParam()" id="openQuestion" type="radio" name="questionType" value="Open"><br>


    Write a question to add: <input type="text" name="question"> <br>
    <span id="weight" >Weight: <input type="number" name="weight"></span><br>
    Area: <input type="text" id="area" name="area"><br>
    Subcategory: <input type="text" name="subcat"> <br>

   <div id="params"> 
       Parameters: <br>
    <label>Performance</label>
    <input type="radio" name="PP" value="Performance">
    <label>Potential</label>
    <input type="radio" name="PP" value="Potential">
   </div>
    
</form> --}}
{{-- <br>
<br> --}}
---------------------------------
<div>
    <h3>Show Survey:</h3>
<form id="showSurvey" action="/showSurvey">
    <select id="surveyShowID" name="surveyShowID">
        <option value=00>---</option>
        @foreach($surveys as $survey)
            <option value={{$survey->id}}>{{$survey->name}}</option>
        @endforeach
    </select>
    <button>Show</button>  
</form>
<br>
@if(session('showSurvey'))
        <?php echo session('showSurvey')  ?>
@endif


</div>

@if(session('msgError'))
    <p>
        <?php echo session('msgError')  ?>
    </p>
@endif







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





</script>

    
</body>
</html>
