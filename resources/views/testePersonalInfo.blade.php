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
    Nome: <span>{{$users->name}}</span>
        <br>
    Birthday date: <span>{{$users->birthDate}}</span>
        <br>
    Email: <span>{{$users->email}}</span>
        <br>

        Status: <span>{{$users->status}}</span>
        <br>
        Age: <span>{{$age}}</span>
        <br>
        NIF: <span>{{$users->taxNumber}}</span>
        <br>
        
        Academic Qualifications: <span>{{$users->academicQual}}</span>
        <br>
    Mobile:  <span>{{$users->phone}}</span>
    </div>
<br>
    <div id="addressData">
        Address: <span>{{$users->address}}</span>
        <br>
        ZIP-Code: <span>{{$users->zip_code}}</span>
        <br>
        City: <span>{{$users->city}}</span>
        <br>
    </div>
<br>
    <div id="bankData">
    IBAN: <span>{{$users->iban}}</span>
    </div>
    <br>
    <div id="socialNetwork">
        Facebook: <span></span>
        Instagram: <span></span>
        Linkedin: <span></span>
    </div>



</body>
</html>
