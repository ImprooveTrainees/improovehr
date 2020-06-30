@extends('layouts.template')

@section('title')
    Improove HR - Reports
@endsection

@section('sidebarreports')
active
@endsection

@section('content')
<div class="shadow p-1 bg-white cardbox1">
        <div class="titleReport">
            <p>Create Report</p>
            <hr >

        <div class="form-group1" >

            <form action="/reports" method="POST" class="action">
                <div class="reportSelects">
                    @csrf
                    <label for="absencetype" class="">Choose type of absence</label>
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

        <div class="form-group2" >

            <div class="reportSelects">
                <label for="iduser" class="subTitleReport">Choose employee (S)</label>
                <select class="form-control " name="iduser" id="iduser">
                    @for($i=0;$i<count($array_users);$i+=2)
                        <option value={{$array_users[$i]}}>{{$array_users[$i+1]}}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-group reportSelects" >

            <div class="reportDateSpace">
                <label class="subTitleReport2">Choose the interval</label>
                <div class="reportStart">

                    <label class="reportDate" for="start_date" >Start date: </label>
                    <input class="form-control" type="date" id="start_date" name="start_date">
                </div>
                <div class="reportStart">
                    <label class="reportDate" for="end_date">End date: </label>
                    <input class="form-control" type="date" id="end_date" name="end_date">
                </div>
            </div>
        </div>
            <button type="submit" class="form-group btn btn-outline-primary bprofile">Create table</button>

        </form>
    </div>
</div>

@endsection
