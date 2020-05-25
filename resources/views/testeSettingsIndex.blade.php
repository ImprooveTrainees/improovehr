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
<select>
  <option>Monday</option>
  <option>Tuesday</option>
  <option>Wednesday</option>
  <option>Thursday</option>
  <option>Friday</option>
</select>

<strong><label>End</label></strong>
<select>
  <option>Monday</option>
  <option>Tuesday</option>
  <option>Wednesday</option>
  <option>Thursday</option>
  <option>Friday</option>
</select>

<strong><label>Hours per Week:</label></strong><input type="number">


<h4>Holidays/Absences</h4>
<strong><label>Extra Days:</label></strong>
<input type="date" id="dateSelected">
<button onclick="addDate()">Add date</button>

<ul id="dateList">

</ul>

<strong><label>Limit of vacations per year:</label></strong>
<input type="number">

<h4>Alerts</h4>
<strong><label>Holidays:</label></strong>
<select>
  <option>Yes</option>
  <option>No</option>
</select>
<br>

<strong><label>Birthdays:</label></strong>
<select>
  <option>Yes</option>
  <option>No</option>
</select>
<br>

<strong><label>Evaluations:</label></strong>
<select>
  <option>Yes</option>
  <option>No</option>
</select>
<br>

<strong><label>Flex-Time:</label></strong>
<select>
  <option>Yes</option>
  <option>No</option>
</select>
<br>

<strong><label>Not working:</label></strong>
<select>
  <option>Yes</option>
  <option>No</option>
</select>




</div>

<script>
function addDate() {
  var ul = document.getElementById("dateList");
  var li = document.createElement("li");
  li.appendChild(document.createTextNode(document.getElementById('dateSelected').value));
  li.setAttribute("value", document.getElementById('dateSelected').value);
  ul.appendChild(li);
}
</script>

</body>
</html>
