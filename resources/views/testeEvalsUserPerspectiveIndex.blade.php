@extends('layouts.template')

@section('title')
    Improove HR - Create Evaluation
@endsection

@section('sidebarCompleteSurvey')
active
@endsection

@section('openEvaluations')
open
@endsection

@section('content')

<div class="shadow p-1 bg-white cardbox1">

    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
            <thead>
                <tr>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Own Evaluations</th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;">Type</th>
                    <th class="d-none d-sm-table-cell" style="width: 10%;">Time Left</th>
                    <th class="d-none d-sm-table-cell" style="width: 5%;">Submitted</th>
                    <th style="width: 5%;"></th>
                </tr>
            </thead>
            @if(count($surveysHTML) == 0)
            <h4>There are no surveys available to complete at the moment.</h4>
                @else
                @for($i = 0; $i < count($surveysHTML); $i++)
                    <tbody>
                        <tr>
                            <td class="font-w600 font-size-sm">
                                <label for="">{{$surveysHTML[$i]->name}}</label>
                            </td>
                            <td class="font-w600 font-size-sm">
                                <a href="">{{$surveysHTMLType[$i]}}</a>
                            </td>
                            @if($daysLeftSurveyHTML[$i] != "Expired")
                                <td>{{$daysLeftSurveyHTML[$i]->format('%d days left')}}({{$dateLimitSurveyHTML[$i]}})</td>
                            @else
                                <td>Expired</td>
                            @endif
                            @if($submittedSurveyHTML[$i] == 1)
                                <td>Yes</td>
                                <td><i class='fas fa-check'></i></td>
                            @else
                                <td>No</td>
                            @if($daysLeftSurveyHTML[$i] != "Expired") <!-- Se não tiver sido submetido, e não tiver expirado -->
                                <td><a href="showSurveyUser/{{$surveysHTML[$i]->id}}"><i class='fas fa-pencil-alt'></i></a></td>

                            @endif

                            @endif
                        </tr>
                    </tbody>
                    @endfor
                @endif
        </table>
    </div>


    @if(session('completed'))
        <div class="alert alert-info alert-block">
            <?php echo session('completed')  ?>
        </div>
    @endif

</div>

@endsection

</body>
</html>
