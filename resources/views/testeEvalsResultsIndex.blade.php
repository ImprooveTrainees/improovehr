@extends('layouts.template')

@section('title')
    Improove HR - Show Results
@endsection

@section('sidebarShowResults')
active
@endsection

@section('openEvaluations')
    open
    @section('Results')
        open
    @endsection
@endsection

@section('content')

<div class="shadow p-1 bg-white cardbox1">
    <div class="colors">
        <h2>Survey Results</h2>

        <h4 class="">{{$submitted}} of {{$total}} submitted.</h4>

    </div>

    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
            <thead>
                <tr>
                    <th class="d-none d-sm-table-cell" style="width: 5%;"><b>User</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;"><b>Evaluation</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;"><b>Type</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 5%;"></th>
                </tr>
            </thead>
                    <tbody>

                        @for($i = 0; $i < count($surveyNames); $i++)

                        <tr>
                            <td class="font-w600 font-size-sm">
                                <label for="">{{$userNames[$i]->name}}</label>
                            </td>
                            <td class="font-w600 font-size-sm">
                                <label>{{$surveyNames[$i]->name}}</label>
                            </td>
                            <td>
                                <label for="">{{$surveyType[$i]->description}}</label>
                            </td>
                            <td>
                                <a href="/showResults/{{$surveyNames[$i]->id}}/{{$userNames[$i]->id}}"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @endfor
                    </tbody>
        </table>
    </div>
</div>

@endsection



</body>
</html>
