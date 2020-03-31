@extends('layouts.template')

@section('title')
    Improove HR - Holidays/Absences
@endsection

@section('sidebarsettings')
active
@endsection

@section('content')

<div class="shadow p-1 bg-white cardboxsettings">

    <div class="container" id="settingstab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#general">General</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#personalpage">Personal Page</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#flextime">Flex-Time</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#holidays">Holidays/Absences</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#employees">Employees</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#evaluations">Evaluations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#reports">Reports</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            {{-- GENERAL --}}
          <div id="general" class="container tab-pane active">
        <form class="form-group settingsform" action="">

        <p>Company</p>
        <hr id="companyline">

        <div id="entreprisename">
            <label for="">Company Name:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert Company Name">
        </div>

        <div id="companyaddress">
            <label for="">Company Address:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert Company Address">
        </div>

        <div id="generalemail">
            <label for="">General Email:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert General Email">
        </div>

        <div id="generalmobile">
            <label for="">General Mobile:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert General Mobile">
        </div>

        <div id="country">
            <label for="">Country:</label>
            <input type="text" name="entreprisename" class="form-control" placeholder="Insert Country">
        </div>
        <button type="submit" class="form-group btn btn-outline-primary bsettings">Save</button>
        </form>

        <p>Alerts</p>
        <hr>

        <div id="allnotifications" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches">
            <label class="custom-control-label" for="customSwitches">All Notifications</label>
        </div>

        </div>

        {{-- PERSONAL PAGE --}}

        <div id="personalpage" class="container tab-pane fade">
            <br>
            <h1>PERSONAL PAGE</h1>
        </div>


        {{-- FLEX-TIME --}}

        <div id="flextime" class="container tab-pane fade">
            <br>
            <h1>FLEX-TIME</h1>
        </div>

        {{-- HOLIDAYS --}}

        <div id="holidays" class="container tab-pane fade">
            <br>
            <h1>HOLIDAYS</h1>
        </div>

        {{-- EMPLOYEES --}}

        <div id="employees" class="container tab-pane fade">
            <br>
            <h1>EMPLOYEES</h1>
        </div>

        {{-- EVALUATIONS --}}

        <div id="evaluations" class="container tab-pane fade">
            <br>
            <h1>EVALUATIONS</h1>
        </div>

        {{-- REPORTS --}}

        <div id="reports" class="container tab-pane fade">
            <br>
            <h1>REPORTS</h1>
        </div>

        </div>
    </div>
</div>

@endsection
