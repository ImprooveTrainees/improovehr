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
            <strong><label>Company Name:</label></strong>
            @if($officeUserLogged->description == null)
            <input type="text" name="companyName" class="" placeholder="Insert your company name">
            @else
                <input type="text" name="companyName" class="" placeholder="Insert your company name" value={{$officeUserLogged->description}}>
            @endif
        </div>

        <div id="companyaddress">
            <strong><label>Address:</label></strong>
            @if($officeUserLogged->adress == null)
              <textarea name="companyAdress" placeholder="Insert your company's address"></textarea>
            @else
                <textarea name="companyAdress" style="height: 30px" placeholder="Insert your company's address">{{$officeUserLogged->adress}}</textarea>
            @endif
        </div>

        <div id="generalemail">
            <strong><label>E-mail:</label></strong>
            @if($officeUserLogged->mail == null)
              <input type="text" name="emailAdress" class="" placeholder="Insert your company's email">
            @else
                <input type="text" name="emailAdress" class="" placeholder="Insert your company's email" value={{$officeUserLogged->mail}}>
            @endif
        </div>

        <div id="generalmobile">
            <strong><label>Contact:</label></strong>
            @if($officeUserLogged->contact == null)
              <input type="text" name="contact" class="" placeholder="Insert your company's phone number">
            @else
                <input type="text" name="contact" class="" placeholder="Insert your company's phone number" value={{$officeUserLogged->contact}}>
            @endif
        </div>

        <div id="country">
            <strong><label>Country:</label></strong>
            @if($officeUserLogged->country == null)
              <input type="text" name="country" class="" placeholder="Insert your company's country">
            @else
                <input type="text" name="country" class="" placeholder="Insert your company's country" readonly value={{$officeUserLogged->country}}>
            @endif
        </div>

  

        <p>Alerts</p>
        <hr>

        {{-- <div id="allnotifications" class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="customSwitches">
            <label class="custom-control-label" for="customSwitches">All Notifications</label>
        </div> --}}

<div id="holidaysnoti" class="custom-control custom-switch">
        <label>Holidays Notifications</label>
            <select name="holidaysAlert">
                @if($lastSettingsGeneral->alert_holidays == 1)
                <option selected value="1">Yes</option>
                <option value="0">No</option>
                @else 
                <option value="1">Yes</option>
                <option selected value="0">No</option>
                @endif
            </select>
        </div>

        <div id="birthdaynoti" class="custom-control custom-switch">
            <label>Birthdays Notifications</label>
            <select name="BDaysAlert">
                @if($lastSettingsGeneral->alert_birthdays == 1)
                  <option selected value="1">Yes</option>
                  <option value="0">No</option>
                @else 
                  <option value="1">Yes</option>
                  <option selected value="0">No</option>
                @endif
              </select>
        </div>

        <div id="evaluationsnoti" class="custom-control custom-switch">
            <label>Evaluations Notifications</label>
            <select  name="evalsAlert">
                @if($lastSettingsGeneral->alert_evaluations == 1)
                  <option selected value="1">Yes</option>
                  <option value="0">No</option>
                @else 
                  <option value="1">Yes</option>
                  <option selected value="0">No</option>
                @endif
              </select>
        </div>

        <div id="flextimenoti" class="custom-control custom-switch">
            <label>Flex-Time Notifications</label>
            <select name="flexAlert">
                @if($lastSettingsGeneral->alert_flextime == 1)
                  <option selected value="1">Yes</option>
                  <option value="0">No</option>
                @else 
                  <option value="1">Yes</option>
                  <option selected value="0">No</option>
                @endif
              </select>
        </div>

        <div id="notworkingnoti" class="custom-control custom-switch">
            <label>Not Working Notifications</label>
            <select name="notWorkingAlert">
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
            Days:
  <br>
  <strong><label>Start</label></strong>
  <select name="startDay">
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

  <strong><label>End</label></strong>
  <select name="endDay">
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

  <strong><label>Hours per day:</label></strong>
  @if($lastSettingsGeneral->flextime_dailyHours == null)
    <input type="number" name="hoursPerDay" class="" placeholder="Insert a number of work hours per day">
  @else
      <input type="number" value={{$lastSettingsGeneral->flextime_dailyHours}} name="hoursPerDay" class="" placeholder="Insert a number of work hours per day">
  @endif
  <br>
  
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
        </div>

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
                <strong><label>Extra Days:</label></strong>
                <input type="date" id="dateSelected">
                Description: <input type="text" id="descriptionExtraDay">
                <button type="button" onclick="addDate()">Add date</button>
                <br>
            <ul id="dateList">
              
            </ul>

            </div>

            Current dates: <br>
            @foreach($extraDays as $days)
              {{$days->extra_day}} {{$days->description}} <a href="/removeExtraDay/{{$days->id}}"><i class="fas fa-times"></i></a><br> 
            @endforeach
            <div id="holidaysExtra2">
                <label for="">Holidays Limit:</label>
                @if($lastSettingsGeneral->limit_vacations == null)
                    <input type="number" name="limitVacations" class="" placeholder="Insert vacations limit (days)">
                @else
                    <input type="number" value={{$lastSettingsGeneral->limit_vacations}} name="limitVacations" class="" placeholder="Insert vacations limit (days)">
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

        <!-- Modal Add New Day -->
        <div class="modal fade" id="modalNewDay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Extra Day</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" class="action">
                        <div class="modal-body">
                            @csrf
                            <label for="start_date" >New Date </label>
                            <input type="date" id="start_date" name="start_date">
                            <input type="hidden" value=1 name="op">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Modal Add New Day -->

            <!-- Modal Limit Holidays -->
            <div class="modal fade" id="editHolidaysLimit" tabindex="-1" role="dialog" aria-labelledby="editEndDayLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="editEndDayLabel">Holidays Limit Days</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
    
                        <div class="modal-body2">
                        @csrf
                        <h5>New Limit:</h5>
                        <input type="number">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        
                </div>
                </div>
            </div>
            <!-- End Modal Limit Holidays -->



        </div>
    </div>

    
    </form>

</div>
<button onclick="execForm()" type="submit" class="form-group btn btn-outline-primary bsettings">Save</button>

@if(session('msg'))
<div class="alert alert-info alert-block">
    <?php echo session('msg')  ?>
</div>
@endif



<script>
    function addDate() {
      var ul = document.getElementById("dateList");
      var li = document.createElement("li");
      li.appendChild(document.createTextNode(document.getElementById('dateSelected').value + " | " +  document.getElementById('descriptionExtraDay').value));
      li.setAttribute("value", document.getElementById('dateSelected').value);
      ul.appendChild(li);
    
      var form = document.getElementById('form');
      var hiddenInput = document.createElement("input");
      hiddenInput.setAttribute("type", "hidden");
      hiddenInput.setAttribute("value",  document.getElementById('dateSelected').value);
      hiddenInput.setAttribute("name",  "dateList[]");
      form.appendChild(hiddenInput); //cria hidden inputs como array, com os valores das datas, para
      //ser mais fácil transmitir para o php
    
      var hiddenInputDescription =  document.createElement("input");
      hiddenInputDescription.setAttribute("type", "hidden");
      hiddenInputDescription.setAttribute("value",  document.getElementById('descriptionExtraDay').value);
      hiddenInputDescription.setAttribute("name",  "descriptionExtraDay[]");
      form.appendChild(hiddenInputDescription);
    
    }

    function execForm() {
      document.getElementById('form').submit();
    }
</script>

@endsection
