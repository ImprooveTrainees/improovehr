@extends('layouts.template')

@section('title')
    Improove HR - Employees
@endsection

@section('sidebaremployees')
active
@endsection

@section('content')
<div class="shadow p-1 bg-white cardboxsettings">

    <div class="container" id="settingstab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#general">Absence</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#flextime">Employee(s)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#holidays">Time Interval</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#evaluations">Export</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">


            {{-- Absence --}}
          <div id="general" class="container tab-pane active">
          <br>
        <div class="form-group settingsform" >

        <p>Choose Type Of Absence</p>
        <hr id="companyline">

        <div class="buttonReport">
        <button type="submit" class="form-group btn btn-outline-primary bsettings reportContinue">Continue</button>
        </div>
        </div>

        </div>


        {{-- Employee --}}

        <div id="flextime" class="container tab-pane fade">
        <br>
        <div class="form-group settingsform" >

        <p>Choose Employee(s)</p>
        <hr id="companyline">

        <div class="reportEmployees">
        <select name="employees">

        @for($i=0;$i<count($array_users);$i+=2)

            <option value={{$array_users[$i]}}>{{$array_users[$i+1]}}</option>

        @endfor

        </select>
        </div>
        <div class="buttonReport">
        <button type="submit" class="form-group btn btn-outline-primary bsettings reportContinue">Continue</button>
        </div>

        </div>
        </div>


        {{-- Time Interval --}}

        <div id="holidays" class="container tab-pane fade">
            <br>
            <div class="form-group settingsform" >

        <p>Choose Time Interval</p>
        <hr id="companyline">

        <div class="buttonReport">
        <button type="submit" class="form-group btn btn-outline-primary bsettings reportContinue">Continue</button>
        </div>
        </div>
        </div>

        {{-- Export --}}

        <div id="evaluations" class="container tab-pane fade">
            <br>
            <div class="form-group settingsform" >



        <button type="submit" class="form-group btn btn-outline-primary bsettings">Export to Excel</button>
        </div>
        </div>


        </div>
    </div>
</div>


@endsection
