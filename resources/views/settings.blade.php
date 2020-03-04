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
    <div id="enterprisedata">
        <hr>
         General Company Settings<br><br>
    Company name: <span>{{$compName}}</span> <br>
    Company address: <span>{{$compAddress}}</span> <br>
    Company mail: <span>{{$compMail}}</span> <br>
    Company contact: <span>{{$compContact}}</span> <br>
    Company country: <span>{{$compCountry}}</span> <br>
    <hr>
    outro<br><br>

        {{-- {{$userAttachments}} --}}





    </span>
    <hr>


    </div>

</body>
</html>
