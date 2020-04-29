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
 Total hours reported: {{$hoursReportedTotal}} of 160
 <br>
 You must report more {{$hoursLeftReport}} hours
 <br>
<button onclick="last2weeks()">Last 15 days</button>
<button onclick="currentWeek()">This Week</button>


 <div style='display: none;' id="currentWeek">
    <br>
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
    <br>
    Last week
    <br>
    {{$lastWeek}}
    <table>
        <tr>
    
        <th>{{date( 'D', strtotime( '-1 week monday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-1 week monday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-1 week tuesday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-1 week tuesday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-1 week wednesday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-1 week wednesday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-1 week thursday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-1 week thursday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-1 week friday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-1 week friday this week'))}}
        </th>
    
        </tr>
        <tr>
        <td>{{$mondayLastWTotal}} hours</td>
        <td>{{$tuesdayLastWTotal}} hours</td>
        <td>{{$wednesdayLastWTotal}} hours</td>
        <td>{{$thursdayLastWTotal}} hours</td>
        <td>{{$fridayLastWTotal}} hours</td>
        </tr> 
    
    </table>
    <br>
    Two weeks ago
    <br>
    {{$last2weeks}}
    <br>

    <table>
        <tr>
    
        <th>{{date( 'D', strtotime( '-2 week monday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-2 week monday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-2 week tuesday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-2 week tuesday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-2 week wednesday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-2 week wednesday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-2 week thursday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-2 week thursday this week'))}}
        </th>
        <th>{{date( 'D', strtotime( '-2 week friday this week'))}}
            <br>
            {{date( 'd F', strtotime( '-2 week friday this week'))}}
        </th>
    
        </tr>
        <tr>
        <td>{{$mondayLast2WTotal}} hours</td>
        <td>{{$tuesdayLast2WTotal}} hours</td>
        <td>{{$wednesdayLast2WTotal}} hours</td>
        <td>{{$thursdayLast2WTotal}} hours</td>
        <td>{{$fridayLast2WTotal}} hours</td>
        </tr>
    
    </table>
    
    
    <br>
    {{$totalHours15days}} hours reported in the last 2 weeks.
    <br>
    {{$hoursToReportPer15Days}} hours left to report.
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