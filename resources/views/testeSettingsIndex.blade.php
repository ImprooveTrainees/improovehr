<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/041a9ee086.js" crossorigin="anonymous"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<h2>Settings</h2>


<h4>General</h4>
<div>
<form action="/saveSettings/{{$officeUserLogged->id}}" method="post" id="form">
    @csrf
  <strong><label>Company Name:</label></strong>
  @if($officeUserLogged->description == null)
    <input type="text" name="companyName" class="" placeholder="Insert your company name">
  @else
      <input type="text" name="companyName" class="" placeholder="Insert your company name" value={{$officeUserLogged->description}}>
  @endif

  <strong><label>Address:</label></strong>
  @if($officeUserLogged->adress == null)
    <textarea name="companyAdress" placeholder="Insert your company's address"></textarea>
  @else
      <textarea name="companyAdress" style="height: 30px" placeholder="Insert your company's address">{{$officeUserLogged->adress}}</textarea>
  @endif

  <strong><label>E-mail:</label></strong>
  @if($officeUserLogged->mail == null)
    <input type="text" name="emailAdress" class="" placeholder="Insert your company's email">
  @else
      <input type="text" name="emailAdress" class="" placeholder="Insert your company's email" value={{$officeUserLogged->mail}}>
  @endif

  <strong><label>Contact:</label></strong>
  @if($officeUserLogged->contact == null)
    <input type="text" name="contact" class="" placeholder="Insert your company's phone number">
  @else
      <input type="text" name="contact" class="" placeholder="Insert your company's phone number" value={{$officeUserLogged->contact}}>
  @endif

  <strong><label>Country:</label></strong>
  @if($officeUserLogged->country == null)
    <input type="text" name="country" class="" placeholder="Insert your company's country">
  @else
      <input type="text" name="country" class="" placeholder="Insert your company's country" readonly value={{$officeUserLogged->country}}>
  @endif


  <h4>Flex Time</h4>
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

  <h4>Holidays/Absences</h4>
  <strong><label>Extra Days:</label></strong>
  <input type="date" id="dateSelected">
  Description: <input type="text" id="descriptionExtraDay">
  <button type="button" onclick="addDate()">Add dates</button>

  <ul id="dateList">

  </ul>

  Current dates: <br>
  @foreach($extraDays as $days)
    {{$days->extra_day}} | {{$days->description}} <a href="/removeExtraDay/{{$days->id}}"><i class="fas fa-times"></i></a><br> 
  @endforeach


  <strong><label>Limit of vacations per year:</label></strong>
  @if($lastSettingsGeneral->limit_vacations == null)
    <input type="number" name="limitVacations" class="" placeholder="Insert vacations limit (days)">
  @else
      <input type="number" value={{$lastSettingsGeneral->limit_vacations}} name="limitVacations" class="" placeholder="Insert vacations limit (days)">
  @endif




  <h4>Alerts</h4>

  <strong><label>Holidays:</label></strong>
  <select name="holidaysAlert">
    @if($lastSettingsGeneral->alert_holidays == 1)
      <option selected value="1">Yes</option>
      <option value="0">No</option>
    @else 
      <option value="1">Yes</option>
      <option selected value="0">No</option>
    @endif
  </select>
  <br>

  <strong><label>Birthdays:</label></strong>
  <select name="BDaysAlert">
    @if($lastSettingsGeneral->alert_birthdays == 1)
      <option selected value="1">Yes</option>
      <option value="0">No</option>
    @else 
      <option value="1">Yes</option>
      <option selected value="0">No</option>
    @endif
  </select>
  <br>

  <strong><label>Evaluations:</label></strong>
  <select  name="evalsAlert">
    @if($lastSettingsGeneral->alert_evaluations == 1)
      <option selected value="1">Yes</option>
      <option value="0">No</option>
    @else 
      <option value="1">Yes</option>
      <option selected value="0">No</option>
    @endif
  </select>
  <br>

  <strong><label>Flex-Time:</label></strong>
  <select name="flexAlert">
    @if($lastSettingsGeneral->alert_flextime == 1)
      <option selected value="1">Yes</option>
      <option value="0">No</option>
    @else 
      <option value="1">Yes</option>
      <option selected value="0">No</option>
    @endif
  </select>
  <br>

  <strong><label>Not working:</label></strong>
  <select name="notWorkingAlert">
    @if($lastSettingsGeneral->alert_notworking == 1)
      <option selected value="1">Yes</option>
      <option value="0">No</option>
    @else 
      <option value="1">Yes</option>
      <option selected value="0">No</option>
    @endif
  </select>

  <br>
<button type="submit">Save</button>
</form>

</div>

@if(session('msg'))
<div class="alert alert-info alert-block">
    <?php echo session('msg')  ?>
</div>
@endif



<script>
function addDate() {
  var ul = document.getElementById("dateList");
  var li = document.createElement("li");
  li.appendChild(document.createTextNode(document.getElementById('dateSelected').value));
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
</script>

</body>
</html>
