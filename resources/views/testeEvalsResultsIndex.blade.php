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
{{$submitted}} of {{$total}} submitted.
<br>
<table style="border-collapse:separate;border-spacing:15px;">
    <tr>
        <th><h2>User</h2></th>
        <th><h2>Evaluation</h2></th>
        <th><h2>Type</h2></th>
        <th><h2></h2></th>
    </tr>

    @for($i = 0; $i < count($surveyNames); $i++)
        <tr>
            <td>{{$userNames[$i]->name}}</td>
            <td>{{$surveyNames[$i]->name}}</td>
            <td>{{$surveyType[$i]->description}}</td>
            <td><a href="/showResults/{{$surveyNames[$i]->id}}/{{$userNames[$i]->id}}"><i class="fas fa-eye"></i></a></td>
        </tr>
    @endfor

</table>





</body>
</html>
