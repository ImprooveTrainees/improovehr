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
        EnterPrise Data<br><br>
    Role: <span>{{$role}}</span> <br>
    Type of contract: <span>{{$contractype}}</span><br>
    Department: <span>{{$department}}</span><br>
    Admission Date: <span>{{$startdate}}</span><br>
    End of contract: <span>{{$endDate}}</span>
    <hr>
    Documents<br><br>
    User Attachments: <span>
        @foreach ($userAttachments as $item)
        {{$item->files}}<br>
        @endforeach
        {{-- {{$userAttachments}} --}}





    </span>
    <hr>


    </div>

</body>
</html>
