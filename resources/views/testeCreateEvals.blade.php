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

    <div style='display: none;' id='hideSubcat'>

    <form action="/newSubCat">
        @csrf
     <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
    New:<input name="subCatNewName">
    <button type="submit">Create Subcategory</button>
    </form>
    

<form action='/addSubcatArea'>
@csrf
<input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
Add: <select name='selectedSubCat'>
        @for($i = 0; $i < count($allSubCats); $i++)
        <option value={{$allSubCatsId[$i]}}>{{$allSubCats[$i]}}</option>   
        @endfor
      </select>

     <strong>to</strong>
     <select name='selectedArea'>
            @foreach($surveyAreas as $aps) 
                <option value={{$aps->id}}>{{$aps->description}}</option>
            @endforeach   
     </select>
     <button>Add</button>
     </form>
     
     <form action='/remSubcatArea'>
     @csrf
     <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
     Remove: <select name='choosenAreaSubCatId'>
        <?php echo $subCatsLoop ?>
     </select>
     <button type='submit'>Remove</button>
    </form>

            
    </div>


<!-- //End Button Subcategory   -->

<!-- //Begin Button Questions -->

<div style='display: none;' id='hideQuestions'>
                
    <form action="/newQuestion">
    <input type="hidden" id="questionTypeForm" name="questionTypeForm" value="">
    <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
    @csrf
    
    Type: 
    @foreach($questionTypes as $type) 
        <label>{{$type->description}}&nbsp;</label>
        @if($type->description == "Open") 
            <input onchange="hideParam()" id="openQuestion" type="radio" name="questionType" value={{$type->id}}>
        
        @else 
            <input onchange="hideParam()" type="radio" name="questionType" value={{$type->id}}>
        
        @endif
        
    @endforeach
    <br>
    <br>  
    
    <div style="display: none;" id="numericQuestionSelect" value="">
    Write a question to add: <input type="text" name="question"> <br>
    <span id="weight">Weight: <input type="number" step="0.01" min="0" name="weight"></span><br>

    <div id="params">
    Parameters: <br>
    @foreach($PPs as $pp) 
        <label>{{$pp->description}}</label>&nbsp;
        <input type="radio" name="PP" value={{$pp->id}}>
    @endforeach
    </div>
    Add: <select name='choosenSubCatId'>
        {{!!  $subCatsLoopQuestions !!}}
     </select>
    <button type='submit'>Add</button>
    </div>

    <div style="display: none;" id="openQuestionSelect">
    Write a question to add: <input type="text" name="questionOpen"> <br>

    Add: <select name='choosenAreaId'>
    @foreach($surveyAreas as $area) 
            <option value={{$area->id}}>{{$area->description}}</option>                   
    @endforeach
    </select>
    <button type='submit'>Add</button>
    </div>
    
</form>

    Remove:
    <form action="/remQuestion">
    @csrf
    <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
    <select name="questionIdRemove">
        {{!! $NumericQuestionsLoop !!}}
        {{!!  $openQuestionsLoop !!}}
    </select>
    <button type="submit">Remove</button>
    </form>

</div>




<!-- End Button Questions -->


<!-- Begin Button Users -->

<div style='display: none;' id='hideUserSurvey'>

    <form action='/assignUser'>
    @csrf
    <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
    Assign Users to Survey:<br>
    @foreach($users as $user) 
        <input type="checkbox" id={{$user->name}} name="users[]" value={{$user->id}}>
        <label for={{$user->name}}>{{$user->name}}</label>
        <select onchange="showEvaluatedChoice({{$user->id}})" id="evaluatedChoiceJS{{$user->id}}" name="evalChoice{{$user->id}}">
            <!-- passamos o user id como argumento no select, para o JS nos mostrar o select correcto -->
            <option value="1">...will be evaluated.</option>
            <option value="0">...will evalue</option>
        </select>
        <select style='display: none;' id='showEvaluatedSelection{{$user->id}}' name='evaluatorChoice{{$user->id}}'>
        @foreach($users as $toBeEval) 
            <option value={{$toBeEval->id}}>{{$toBeEval->name}}</option>
        @endforeach
        </select>
        <br>
    @endforeach

    <br>
    <label for="limitDate">Limit Date:</label>
    <input type="date" id="limitDate" name="limitDate">
    <br>
    <button type='submit'>Assign Users</button>
    </form>

    <br>

    <form action='/remUser'>
     @csrf
    <input type="hidden" name="idSurveyAutoShow" value={{$selectedSurveyId}}>
    Remove:<br>
    @foreach($usersAssigned as $user) 
        <input type="checkbox" id={{$user->name}} name="usersRem[]" value={{$user->id}}>
        <label for={{$user->name}}>{{$user->name}}</label><br>
     @endforeach
       <br>
       <button type='submit'>Remove Users</button>
      </form>
        

</div>

<!-- End Button Users -->

<!-- Begin Survey Structure  -->

@if(count($areasHTML) == 0)
    <br>
    There are no areas in this survey yet!
@else 
    <ul>
    @for($i = 0; $i < count($areasHTML); $i++)
        <li><strong>{{$areasHTML[$i]->description}}</strong></li>
        @if(count($subCatsHTML) == 0)
            There are no subcategories in this area yet!
        @else 
            @for($b = 0; $b < count($subCatsHTML); $b+=2)
                @if($subCatsHTML[$b]->id == $areasHTML[$i]->id)
                    &nbsp;&nbsp;<strong>{{$subCatsHTML[$b+1]->description}}</strong><br>
                    @if(count($questionsNumericHTML) == 0)
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;There are no questions in this subcategory!<br>
                    @else 
                        <ol>
                            @for($c = 0; $c < count($questionsNumericHTML); $c++)
                                @if($questionsNumericHTML[$c]->idSubcat == $subCatsHTML[$b+1]->id)
                                    <li>{{$questionsNumericHTML[$c]->description}}</li>
                                @endif                   
                            @endfor
                        </ol>

                    @endif
                @endif
            @endfor

        @endif
    @endfor
    </ul>


@endif

<strong>Open ended questions:</strong><br>
<ul>
@foreach($surveyAreas as $sAreasOpen)
    <li><strong>{{$sAreasOpen->description}}</strong></li>
    @if(count($openQuestionsHTML) == 0)
        There are no open questions for this area!
    @else 
        <ol>
        @for($d = 0; $d < count($openQuestionsHTML); $d++)
            @if($openQuestionsHTML[$d]->idAreaOpenQuest == $sAreasOpen->id)
                <li>{{$openQuestionsHTML[$d]->description}}</li>
            @endif                   
        @endfor
        </ol>
    @endif
@endforeach


</ul>

<div>
    <strong>Users assigned:</strong><br>


</div>
<br>





<!-- End Survey Structure -->


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
