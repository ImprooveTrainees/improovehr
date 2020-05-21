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


    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>




    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<h4>Select a user to see his final average results of a chosen year</h4>


<form action="/finalCalculus" method="post">
    @csrf
<select name="idUser">
    @foreach ($allUsers as $user)
        <option value={{$user->id}}>{{$user->name}}</option>
    @endforeach
</select>

<select name="chosenYear">
    @foreach ($yearsArray as $year)
        <option value={{$year}}>{{$year}}</option>
    @endforeach
</select>
    
<button type="submit">Show</button>

</form>


@if(count($arrayAveragesTable) != 0)
<table>
    <tr>
        <th></th>
        <th>Total Potential</th>
        <th>Total Performance</th>
    </tr>

          @for($i = 0; $i < count($arrayAveragesTable); $i+=3)
                <tr>
                    <th>{{$arrayAveragesTable[$i]}}</th>
                    <td>{{$arrayAveragesTable[$i+1]}}</td>
                    <td>{{$arrayAveragesTable[$i+2]}}</td>
                </tr>      
          @endfor
        

            <tr>
                <th>Average Results</th>
                <th>{{$resultPotential}}</th>
                <th>{{$resultPerformance}}</th>
            </tr>     
</table>

<div>
    <div id="myChart"></div>
</div>


<style>
#myChart {
    max-width: 500px;
    max-height: 900px;
}

</style>

<script>
    
    window.onload = function () {

var chart = new CanvasJS.Chart("myChart", {
	animationEnabled: true,
	title:{
		text: "Average Results Graph"
	},
	axisX: {
		title:"Potential",
      	minimum: 0,
		maximum: 6,
        interval: 2,
      gridThickness: 1
	},
	axisY:{
		title: "Performance",
      	minimum: 0,
	  	maximum: 6,
        interval: 2,
      	gridThickness: 1
	},
	data: [{
		type: "scatter",
		toolTipContent: "<span style=\"color:#4F81BC \"><b>{name}</b></span><br/><b> Potential:</b> {x} <br/><b> Performance:</b></span> {y}",
		name: "Result",
		showInLegend: true,
		dataPoints: [
			{ x: {{$resultPotential}}, y: {{$resultPerformance}} },
		]
	}]
});
chart.render();

}
</script>


@endif
    
    


@if(Session::has('msgError'))
    <p class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ Session::get('msgError') }}</p>
@endif
</body>
</html>
