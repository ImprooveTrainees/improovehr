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

        <p class="reportSubTitle">Choose Type Of Absence</p>



        <div class="reportEmployees">
        <select name="employees">

        @for($i=0;$i<count($array_absences);$i+=2)

            <option value={{$array_absences[$i]}}>{{$array_absences[$i+1]}}</option>

        @endfor

        </select>
        </div>
        </div>

        <hr>

        <div class="form-group" >

        <p class="reportSubTitle">Choose Employee(s)</p>


        <div class="reportEmployees">
        <select name="employees">

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

        <button type="submit" class="form-group btn btn-outline-primary bsettings">Export to Excel</button>
        </div>



        </div>

</div>


@endsection
