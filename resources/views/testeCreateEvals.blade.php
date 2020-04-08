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
    crossorigin="anonymous">
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <h2>New Survey</h2>
    <br>

<form action="">
    @csrf
    Name: <input type="text" name="surveyName"> <br>
    Answer Limit: <input type="number" name="evalLimit"><br>
    Survey Type: <input type="number" name="surveyType"><br>
    <button type="submit">Create Survey</button>
</form>
<form action="">
    @csrf
    Question: <br><br>
    Type: <br>
    <label>Numeric</label>
    <input onchange="hideParam()" type="radio" name="questionType" value="Numeric">
    <label>Open</label>
    <input onchange="hideParam()" id="openQuestion" type="radio" name="questionType" value="Open"><br>


    Write a question to add: <input type="text" name="question"> <br>
    <span id="weight" >Weight: <input type="number" name="weight"></span><br>
    Area: <input type="text" onchange="funcao()" id="area" name="area"><br>
    Subcategory: <input type="text" name="subcat"> <br>

   <div id="params"> 
       Parameters: <br>
    <label>Performance</label>
    <input type="radio" name="PP" value="Performance">
    <label>Potential</label>
    <input type="radio" name="PP" value="Potential">
   </div>


    <br>
    <button type="submit">Create Survey</button>
</form>


<script>
    console.log('teste');
    
function hideParam() {
    if(document.getElementById("openQuestion").checked == true) {
        document.getElementById("params").style.display = "none";
        document.getElementById("weight").style.display = "none";
    }
    else {
        document.getElementById("params").style.display = "block";
        document.getElementById("weight").style.display = "block";
    }

}



</script>

    
</body>
</html>
