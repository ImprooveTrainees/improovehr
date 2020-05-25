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

<table style="border-collapse:separate;border-spacing:15px;">
    <tr>
        <th><h2>Own Evaluations</h2></th>
        <th><h2>Type</h2></th>
        <th><h2>Time Left</h2></th>
        <th><h2>Submitted</h2></th>
        <th><h2></h2></th>
    </tr>

    @if(count($surveysHTML) == 0) 
        There are no surveys available to complete at the moment.
    
    @else
        @for($i = 0; $i < count($surveysHTML); $i++)
        <tr>
            <td>{{$surveysHTML[$i]->name}}</td>
            <td>{{$surveysHTMLType[$i]}}</td>
            @if($daysLeftSurveyHTML[$i] != "Expired")
                <td>{{$daysLeftSurveyHTML[$i]->format('%d days left')}}({{$dateLimitSurveyHTML[$i]}})</td>
            @else 
                <td>Expired</td>
            @endif
            @if($submittedSurveyHTML[$i] == 1)
                <td>Yes</td>
            @else 
                <td>No</td>
                @if($daysLeftSurveyHTML[$i] != "Expired") <!-- Se não tiver sido submetido, e não tiver expirado -->
                    <td><a href="showSurveyUser/{{$surveysHTML[$i]->id}}"><i class='fas fa-pencil-alt'></i></a></td>
                @endif
                
            @endif
        
        </tr>
        @endfor
    @endif
    

</table>

@if(session('completed'))
<div class="alert alert-info alert-block">
    <?php echo session('completed')  ?>
</div>
@endif



</body>
</html>
