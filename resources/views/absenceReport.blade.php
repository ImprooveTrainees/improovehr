@extends('layouts.template')

@section('title')
    Improove HR - Employees
@endsection

@section('sidebaremployees')
active
@endsection

@section('content')


<table class="table table-striped">
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
<a href="{{ route('reports.excel') }}" class="btn btn-success">Export To Excel</a>

@endsection
