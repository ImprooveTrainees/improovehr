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

@section('content')

<div class="shadow p-1 bg-white cardbox11">


<!-- Begin Survey Structure  -->
<div class="surveyHeader">
    <b><h1>{{$surveyType->description}}</h1></b>
        @if($surveyType->id == 1)
            <h4>This is your periodic evaluation. Above you will find {{count($areasHTML)}} main areas that will be evaluated regarding your performance in the last semester. Please answer with honesty and clarity.</h4>
        @else
            <h4>This is {{$willEvaluateNameUser}}'s periodic evaluation. Above you will find {{count($areasHTML)}} main areas that will be evaluated regarding {{$willEvaluateNameUser}}'s performance in the last semester. Please answer with honesty and clarity.</h4>
        @endif

    <h5>Please rate the following sentences on a scale of 1 to {{$surveyAnswerLimit}}, where 1 represents "Poor" and {{$surveyAnswerLimit}} represents "Excellent".</h5>
</div>

    <form action="/storeAnswers">
        <input type="hidden" value={{$selectedSurveyId}} name="selectedSurveyId">
        @if(count($areasHTML) == 0)
            <br>
            There are no areas in this survey yet!
        @else
        <ul>
            <div class="numQuestions">
                @for($i = 0; $i < count($areasHTML); $i++)
                    <li class="areaLi">
                        <label id="areaLabel">{{$areasHTML[$i]->description}} </label>
                    </li>
                        @for($b = 0; $b < count($subCatsHTML); $b+=2)
                            @if($subCatsHTML[$b]->id == $areasHTML[$i]->id)
                                @if($subCatsHTML[$b+1] == '0')
                                    <p class="emptySpace"> This area has no subcategories!</p>
                                @else
                                    &nbsp;&nbsp;<li class="subLi"><strong>{{$subCatsHTML[$b+1]->description}}</strong></li><br>
                                    <ol>

                                        @for($c = 0; $c < count($questionsNumericHTML); $c+=2)
                                            @if($questionsNumericHTML[$c]->id == $subCatsHTML[$b+1]->id)
                                                @if($questionsNumericHTML[$c+1] == '0')
                                                    <p class="emptySpace"> This subcategory has no questions!</p>
                                                @else

                                                        @if($questionsNumericHTML[$c+1]->idPP == 2)
                                                            <input type="hidden" name="questions[]" value={{$questionsNumericHTML[$c+1]->id}}>&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <li class="pontencialQuest">
                                                                <label>{{$questionsNumericHTML[$c+1]->description}}</label>
                                                                <input id="size" class="form-control" required name="answers[]" placeholder="0-{{$surveyAnswerLimit}}" type="number" min="1" max={{$surveyAnswerLimit}}>
                                                            </li>
                                                        @else
                                                            <input type="hidden" name="questions[]" value={{$questionsNumericHTML[$c+1]->id}}> &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <li>
                                                                <label> {{$questionsNumericHTML[$c+1]->description}}</label>
                                                                <input id="size" class="form-control" required name="answers[]" placeholder="0-{{$surveyAnswerLimit}}" type="number" min="1" max={{$surveyAnswerLimit}}>
                                                            </li>
                                                        @endif

                                                @endif

                                            @endif
                                        @endfor
                                    </ol>
                                @endif
                            @endif
                        @endfor
                @endfor
            </div>
        </ul>


        @endif

        <h4 id="openClass"><strong>Open ended questions:</strong></h4>
        <ul>
        @foreach($surveyAreas as $sAreasOpen)
            <li class="areaLi"><label id="areaLabel">{{$sAreasOpen->description}}</label></li>
                <ol>
                @for($d = 0; $d < count($openQuestionsHTML); $d+=2)
                    @if($openQuestionsHTML[$d]->id == $sAreasOpen->id)
                        @if($openQuestionsHTML[$d+1] == '0')
                        <p class="emptySpace">This area has no open questions!</p>
                        @else
                        <li id="openLi">{{$openQuestionsHTML[$d+1]->description}}</li>
                        <input class="form-control" type="hidden" name="questions[]" value={{$openQuestionsHTML[$d+1]->id}} >
                        <textarea id="areaText" class="form-control" required name="answers[]" placeholder="Write your answer here" rows="4" cols="50"></textarea>
                        @endif
                    @endif
                @endfor
                </ol>
        @endforeach
        </ul>
            <div id="surveyBtn">
                <button class="btn btn-success btn-lg" onclick="sweetalert()">Submit Answers</button>
            </div>
    </form>

<!-- End Survey Structure -->

</div>

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
