<html>
<head>
<title>Teste Harvest</title>

</head>

<body>
{{$month}}


<br>
<br>
<br>
<br>
<img src="{{$harvestProfile->avatar_url}}">
<br>
{{$harvestProfile->first_name}}
{{$harvestProfile->last_name}}
<br>
 {{$harvestProfile->email}} 

 <br>
 <br>

<button onclick="last2weeks()">Last 15 days</button>
<button onclick="currentWeek()">This Week</button>


 <div style='display: none;' id="currentWeek">

    This Week
    <br>
    {{$currentWeek}}
    <br>
    {{$totalHours}} of 40 hours | You must report more {{40 - $totalHours}} hours this week.
    <br>
    <br>

    <table>
    <tr>

    <th>{{date( 'D', strtotime( 'monday this week'))}}
        <br>
        {{date( 'd F', strtotime( 'monday this week'))}}
    </th>
    <th>{{date( 'D', strtotime( 'tuesday this week'))}}
        <br>
        {{date( 'd F', strtotime( 'tuesday this week'))}}
    </th>
    <th>{{date( 'D', strtotime( 'wednesday this week'))}}
        <br>
        {{date( 'd F', strtotime( 'wednesday this week'))}}
    </th>
    <th>{{date( 'D', strtotime( 'thursday this week'))}}
        <br>
        {{date( 'd F', strtotime( 'thursday this week'))}}
    </th>
    <th>{{date( 'D', strtotime( 'friday this week'))}}
        <br>
        {{date( 'd F', strtotime( 'friday this week'))}}
    </th>

    </tr>



    <tr>
    <td>{{$mondayTotal}} hours</td>
    <td>{{$tuesdayTotal}} hours</td>
    <td>{{$wednesdayTotal}} hours</td>
    <td>{{$thursdayTotal}} hours</td>
    <td>{{$fridayTotal}} hours</td>
    </tr>



    </table>

</div>


<div style='display: none;' id="last2weeks">
    <table>
        <tr>
    
        <th>{{date( 'D', strtotime( 'monday -2 week'))}}
            <br>
            {{date( 'd F', strtotime( 'monday -2 week'))}}
        </th>
        <th>{{date( 'D', strtotime( 'tuesday -2 week'))}}
            <br>
            {{date( 'd F', strtotime( 'tuesday -2 week'))}}
        </th>
        <th>{{date( 'D', strtotime( 'wednesday -2 week'))}}
            <br>
            {{date( 'd F', strtotime( 'wednesday -2 week'))}}
        </th>
        <th>{{date( 'D', strtotime( 'thursday -2 week'))}}
            <br>
            {{date( 'd F', strtotime( 'thursday -2 week'))}}
        </th>
        <th>{{date( 'D', strtotime( 'friday -2 week'))}}
            <br>
            {{date( 'd F', strtotime( 'friday -2 week'))}}
        </th>
    
        </tr>
        {{-- <tr>
        <td>{{$mondayTotal}} hours</td>
        <td>{{$tuesdayTotal}} hours</td>
        <td>{{$wednesdayTotal}} hours</td>
        <td>{{$thursdayTotal}} hours</td>
        <td>{{$fridayTotal}} hours</td>
        </tr> --}}
    
    </table>


</div>



<script>
function currentWeek() {
    if(document.getElementById("currentWeek").style.display == "none") {
        document.getElementById("currentWeek").style.display = "block";
    }
    else {
        document.getElementById("currentWeek").style.display = "none";
    }
}

function last2weeks() {
    if(document.getElementById("last2weeks").style.display == "none") {
        document.getElementById("last2weeks").style.display = "block";
    }
    else {
        document.getElementById("last2weeks").style.display = "none";
    }
}

</script>


</body>

</html>