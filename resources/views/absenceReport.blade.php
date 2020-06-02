@extends('layouts.template')

@section('title')
    Improove HR - Employees
@endsection

@section('sidebaremployees')
active
@endsection

@section('content')


<div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
            <thead>
                <tr>
                    <th class="d-none d-sm-table-cell" style="width: 5%;"><b>ID USER</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;"><b>USERNAME</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;"><b>STATUS</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 5%;"><b>ABSENCE TYPE</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;"><b>START DATE</b></th>
                    <th class="d-none d-sm-table-cell" style="width: 15%;"><b>END DATE</b></th>

                </tr>
            </thead>
                    <tbody>
                        @foreach($listReports as $list)


                        <tr>
                            <td class="font-w600 font-size-sm">
                            {{$list->iduser}}
                            </td>
                            <td class="font-w600 font-size-sm">
                            {{$list->name}}
                            </td>
                            <td class="font-w600 font-size-sm">
                            {{$list->status}}
                            </td>
                            <td class="font-w600 font-size-sm">
                            {{$list->description}}
                            </td>
                            <td class="font-w600 font-size-sm">
                            {{$list->start_date}}
                            </td>
                            <td class="font-w600 font-size-sm">
                            {{$list->end_date}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
        </table>
    </div>

<!-- <table class="table table-striped">
<thead>
    <th>ID USER</th>
    <th>USERNAME</th>
    <th>STATUS</th>
    <th>ABSENCE TYPE</th>
    <th>START DATE</th>
    <th>END DATE</th>
  </thead>
  <tbody>
  @foreach($listReports as $list)
    <tr>
      <td>{{$list->iduser}}</td>
      <td>{{$list->name}}</td>
      <td>{{$list->status}}</td>
      <td>{{$list->description}}</td>
      <td>{{$list->start_date}}</td>
      <td>{{$list->end_date}}</td>
    </tr>
@endforeach
  </tbody>


</table>
<a href="{{ route('reports.excel') }}" class="btn btn-success">Export To Excel</a> -->

@endsection
