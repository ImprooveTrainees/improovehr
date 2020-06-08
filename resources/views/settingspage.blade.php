@extends('layouts.template')

@section('title')
    Improove HR - Holidays/Absences
@endsection

@section('sidebarsettings')
active
@endsection

@section('content')

<div class="shadow p-1 bg-white cardboxsettings">
    @if(session('msg'))
<div class="alert alert-info alert-block">
    <?php echo session('msg')  ?>
</div>
@endif

    <div class="container" id="settingstab">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#general">General</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#personalpage">Personal Page</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#flextime">Flex-Time</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#holidays">Holidays/Absences</a>
          </li>
        </ul>

<!-- Tab panes -->
<div class="tab-content">


            {{-- GENERAL PAGE --}}
<div id="general" class="container tab-pane active">

    <form action="/saveSettings/{{$officeUserLogged->id}}" method="post" id="form">

        <p>Company</p>
        <hr id="companyline">

        <div id="entreprisename">
            <label>Company Name:</label>
            @if($officeUserLogged->description == null)
            <input type="text" name="companyName" class="form-control" placeholder="Insert your company name">
            @else
                <input type="text" name="companyName" class="form-control" placeholder="Insert your company name" value={{$officeUserLogged->description}}>
            @endif
        </div>

        <div id="companyaddress">
            <label>Address:</label>
            @if($officeUserLogged->adress == null)
              <input type="text" name="companyAdress" placeholder="Insert your company's address">
            @else
                <input type="text" name="companyAdress" class="form-control" style="height: 30px" placeholder="Insert your company's address" value="{{$officeUserLogged->adress}}">
            @endif
        </div>

        <div id="generalemail">
            <label>E-mail:</label>
            @if($officeUserLogged->mail == null)
              <input type="text" name="emailAdress" class="form-control" placeholder="Insert your company's email">
            @else
                <input type="text" name="emailAdress" class="form-control" placeholder="Insert your company's email" value={{$officeUserLogged->mail}}>
            @endif
        </div>

        <div id="generalmobile">
            <label>Contact:</label>
            @if($officeUserLogged->contact == null)
              <input type="text" name="contact" class="form-control" placeholder="Insert your company's phone number">
            @else
                <input type="text" name="contact" class="form-control" placeholder="Insert your company's phone number" value={{$officeUserLogged->contact}}>
            @endif
        </div>

        <div id="country">
            <label>Country:</label>
            @if($officeUserLogged->country == null)
              <input type="text" name="country" class="form-control" placeholder="Insert your company's country">
            @else
                <input type="text" name="country" class="form-control" placeholder="Insert your company's country" readonly value={{$officeUserLogged->country}}>
            @endif
        </div>



        <p>Alerts</p>
        <hr>

        {{-- <div id="allnotifications" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches">
            <label class="custom-control-label" for="customSwitches">All Notifications</label>
        </div> --}}

        <div id="holidaysnoti" >
        <label>Holidays Notifications</label>
            <select name="holidaysAlert" class="form-control">
                @if($lastSettingsGeneral->alert_holidays == 1)
                <option selected value="1">Yes</option>
                <option value="0">No</option>
                @else
                <option value="1">Yes</option>
                <option selected value="0">No</option>
                @endif
            </select>
        </div>

        <div id="birthdaynoti" >
            <label>Birthdays Notifications</label>
            <select name="BDaysAlert"class="form-control">
                @if($lastSettingsGeneral->alert_birthdays == 1)
                  <option selected value="1">Yes</option>
                  <option value="0">No</option>
                @else
                  <option value="1">Yes</option>
                  <option selected value="0">No</option>
                @endif
              </select>
        </div>

        <div id="evaluationsnoti" >
            <label>Evaluations Notifications</label>
            <select  name="evalsAlert" class="form-control">
                @if($lastSettingsGeneral->alert_evaluations == 1)
                  <option selected value="1">Yes</option>
                  <option value="0">No</option>
                @else
                  <option value="1">Yes</option>
                  <option selected value="0">No</option>
                @endif
              </select>
        </div>

        <div id="flextimenoti" >
            <label>Flex-Time Notifications</label>
            <select name="flexAlert" class="form-control">
                @if($lastSettingsGeneral->alert_flextime == 1)
                  <option selected value="1">Yes</option>
                  <option value="0">No</option>
                @else
                  <option value="1">Yes</option>
                  <option selected value="0">No</option>
                @endif
              </select>
        </div>

        <div id="notworkingnoti" >
            <label>Not Working Notifications</label>
            <select name="notWorkingAlert" class="form-control">
                @if($lastSettingsGeneral->alert_notworking == 1)
                  <option selected value="1">Yes</option>
                  <option value="0">No</option>
                @else
                  <option value="1">Yes</option>
                  <option selected value="0">No</option>
                @endif
            </select>
        </div>

</div>


        {{-- FLEX-TIME --}}

 <div id="flextime" class="container tab-pane fade">
     <div id="daysettings">
        <label>Days:</label>
     </div>

     <div id="startFlexdays">
        <label>Start:</label>
        <select name="startDay" class="form-control">
          @if($lastSettingsGeneral->flextime_startDay == 1)
            <option selected value="1">Monday</option>
          @elseif($lastSettingsGeneral->flextime_startDay == 2)
            <option selected value="2">Tuesday</option>
          @elseif($lastSettingsGeneral->flextime_startDay == 3)
            <option selected value="3">Wednesday</option>
          @elseif($lastSettingsGeneral->flextime_startDay == 4)
            <option selected value="4">Thursday</option>
          @elseif($lastSettingsGeneral->flextime_startDay == 5)
            <option selected value="5">Friday</option>
          @endif
        </select>
     </div>

    <div id="endFlexdays">
        <label>End:</label>
        <select name="endDay" class="form-control">
        @if($lastSettingsGeneral->flextime_endDay == 1)
            <option selected value="1">Monday</option>
        @elseif($lastSettingsGeneral->flextime_endDay == 2)
            <option selected value="2">Tuesday</option>
        @elseif($lastSettingsGeneral->flextime_endDay == 3)
            <option selected value="3">Wednesday</option>
        @elseif($lastSettingsGeneral->flextime_endDay == 4)
            <option selected value="4">Thursday</option>
        @elseif($lastSettingsGeneral->flextime_endDay == 5)
            <option selected value="5">Friday</option>
        @endif
        </select>
    </div>

    <div id="hoursperdayFlex">
        <label>Hours per day:</label>
        @if($lastSettingsGeneral->flextime_dailyHours == null)
          <input type="number" name="hoursPerDay" placeholder="Insert a number of work hours per day" class="form-control">
        @else
            <input type="number" value={{$lastSettingsGeneral->flextime_dailyHours}} name="hoursPerDay" class="form-control" placeholder="Insert a number of work hours per day">
        @endif
    </div>

</div>

            {{-- <br>
            <div id="daysflextime">
                <label for="">Days:</label>
                <p>Monday - Friday</p>
                <a data-toggle="modal" data-target="#editFlexDays">
                    <i type="button" class="fas fa-pen"></i>
                </a>
            </div>

            <!-- Modal Change Days -->
        <div class="modal fade" id="editFlexDays" tabindex="-1" role="dialog" aria-labelledby="editEndDayLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="editEndDayLabel">Days</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="" method="POST" class="action">
                    <div class="modal-body2">
                    @csrf
                    <h5>New Days:</h5>
                    <input type="text">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
            </div>
            </div>
        </div>

            <div id="hoursflextime">
                <label>Hours per Week:</label>
                <p>40 Hours</p>
                <a data-toggle="modal" data-target="#editFlexHours">
                    <i type="button" class="fas fa-pen"></i>
                </a>
            </div> --}}

           <!-- Modal Change Hours -->
        {{-- <div class="modal fade" id="editFlexHours" tabindex="-1" role="dialog" aria-labelledby="editEndDayLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="editEndDayLabel">Hours Per Week</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="" method="POST" class="action">
                    <div class="modal-body2">
                    @csrf
                    <h5>New Hours:</h5>
                    <input type="number">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    </form>
            </div>
            </div>
        </div> --}}


    {{-- HOLIDAYS --}}

        <div id="holidays" class="container tab-pane fade">
            <br>
            <div id="holidaysExtra">
                <label>Extra Days:</label>
                <input type="date" id="dateSelected" class="form-control">


            </div>

            <div id="holidaysExtra4">
                <label for="">Description:</label>
                <input type="text" id="descriptionExtraDay" class="form-control">
            </div>

            <div id="holidaysExtra5">
                <button type="button" onclick="addDate()" class="form-group btn btn-outline-primary bsettings2">Add date</button>
                <ul id="dateList">

                </ul>
            </div>

                <label for="" id="currentDatesSettings">Current dates:</label>
                <div id="holidaysExtra6">
                @foreach($extraDays as $days)
                    <p>{{$days->extra_day}}</p>
                        @if ($days->description == null)
                        <p style="display: none">{{$days->description}}</p>
                        @else
                        <p>{{$days->description}}</p>
                        @endif
                    <a href="/removeExtraDay/{{$days->id}}"><i class="fas fa-times"></i></a>
                @endforeach
            </div>


            <div id="holidaysExtra2">
                <label for="">Holidays Limit:</label>
                @if($lastSettingsGeneral->limit_vacations == null)
                    <input type="number" name="limitVacations" placeholder="Insert vacations limit (days)" class="form-control">
                @else
                    <input type="number" value={{$lastSettingsGeneral->limit_vacations}} name="limitVacations" class="form-control" placeholder="Insert vacations limit (days)">
                @endif

            </div>

            <div id="holidaysExtra3">
                <label for="">Absence Justification:</label>
                <select class="form-control" name="Absence" id="absenceJustificationForm">
                    <option selected="selected">Yes</option>
                    <option >No</option>
                </select>
            </div>
        </div>


        </div>
    </div>
    </form>
    <button onclick="execForm()" type="submit" class="form-group btn btn-outline-primary bsettings">Save</button>
</div>



@endsection
