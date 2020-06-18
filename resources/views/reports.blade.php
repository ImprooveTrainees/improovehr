@extends('layouts.template')

@section('title')
    Improove HR - Reports
@endsection

@section('sidebarreports')
active
@endsection

@section('content')
<div class="shadow p-1 bg-white cardboxsettings">
        <h2 class="titleReport">CREATE REPORT</h2>
        <hr>
        <div class="form-group" >
            <p for="absencetype" class="subTitleReport">CHOOSE TYPE OF ABSENCE</p>
            <form action="/reports" method="POST" class="action">
                <div class="reportSelects">
                    @csrf
                    <select class="form-control " name="absencetype" id="absencetype">
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
            <p for="iduser" class="subTitleReport">CHOOSE EMPLOYEE(S)</p>
            <div class="reportSelects">
                <select class="form-control " name="iduser" id="iduser">
                    @for($i=0;$i<count($array_users);$i+=2)
                        <option value={{$array_users[$i]}}>{{$array_users[$i+1]}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group reportSelects" >
            <p class="subTitleReport">CHOOSE TIME INTERVAL</p>
            <div class="reportDateSpace">
                <div class="reportStart">
                    <label class="reportDate" for="start_date" >Start Date: </label>
                    <input class="form-control" type="date" id="start_date" name="start_date">
                </div>
                <div class="reportStart">
                    <label class="reportDate" for="end_date">End Date: </label>
                    <input class="form-control" type="date" id="end_date" name="end_date">
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group buttonArea" >
            <button type="submit" class="form-group btn btn-outline-success bsettings11 createTableReport">CREATE TABLE</button>
        </div>
        </form>
</div>

@endsection
