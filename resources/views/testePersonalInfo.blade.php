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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<img src="" alt="">
    <div id="personalInfo">
    Nome: <span>{{$userName}}</span>
        <br>
    Birthday date: <span>{{$Bdate}}</span>
        <br>
    Email: <span>{{$Email}}</span>
        <br>

        Status: <span>{{$status}}</span>
        <br>
        Age: <span>{{$age}}</span>
        <br>
        NIF: <span>{{$iban}}</span>
        <br>
        
        Academic Qualifications: <span>{{$academicQual}}</span>
        <br>
    Mobile:  <span>{{$mobile}}</span>
    </div>
<br>
    <div id="addressData">
        Address: <span>{{$address}}</span>
        <br>
        ZIP-Code: <span>{{$zip}}</span>
        <br>
        City: <span>{{$city}}</span>
        <br>
    </div>
<br>
    <div id="bankData">
    IBAN: <span>{{$iban}}</span>
    </div>
    <br>
    <div id="socialNetwork">
        Facebook: <span></span>
        Instagram: <span></span>
        Linkedin: <span></span>
    </div>



</body>
</html>
