@extends('layouts.template')

@section('title')
    Improove HR - Employees
@endsection

@section('sidebaremployees')
active
@endsection

@section('content')
<div class="shadow p-1 bg-white cardboxsettings">

        <h2 class="reportTitle">CREATE REPORT</h2>
        <hr>


        <div class="form-group" >

        <p for="absencetype" class="reportSubTitle">Choose Type Of Absence</p>
        <form action="/reports" method="POST" class="action">
        <div class="reportEmployees">

        @csrf

        <select name="absencetype" id="absencetype">

        <option value="0">All Absences</option>
        <option value="1">Vacations</option>
        <option value="2">Excused Absence</option>
                                <option value="3">Unexcused Absence</option>
                                <option value="4">Maternity Leave</option>
                                <option value="5">Medical Leave</option>

        </select>
        </div>
        </div>

        <hr>

        <div class="form-group" >


        <p for="iduser" class="reportSubTitle">Choose Employee(s)</p>


        <div class="reportEmployees">
        <select name="iduser" id="iduser">

        @for($i=0;$i<count($array_users);$i+=2)

            <option value={{$array_users[$i]}}>{{$array_users[$i+1]}}</option>

        @endfor

        </select>
        </div>

        </div>
        <hr>

            <div class="form-group" >

        <p class="reportSubTitle">Choose Time Interval</p>


        <label class="reportDate" for="start_date" >Start Date </label>
        <input type="date" id="start_date" name="start_date">

        <label class="reportDate" for="end_date">End Date </label>
        <input type="date" id="end_date" name="end_date">

        </div>

        <hr>
            <div class="form-group" >

        <button type="submit" class="form-group btn btn-outline-primary bsettings">Create Table</button>
        </div>

        <a href="{{ route('reports.excel') }}" class="btn btn-success">Export To Excel</a>



        </form>

</div>

        <table class="table table-striped">
<thead>
    <th>IDUSER</th>
    <th>USERNAME</th>
    <th>STATUS</th>
    <th>ABSENCETYPENAME</th>
    <th>STARTDATE</th>
    <th>ENDDATE</th>
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


@endsection
