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
<img src="{{$harvestProfile->avatar_url}}" style="width: 60px; height: 60px">
<br>
{{$harvestProfile->first_name}}
{{$harvestProfile->last_name}}
<br>
 {{$harvestProfile->email}} 

 <br>
 <br>
 Total hours reported this month: {{$hoursReportedTotal}} of {{$monthlyHoursWorkDays}}
 <br>
 You must report more {{$hoursLeftReport}} hours this month.
 <br>
 <button onclick="lastMonth()">Last Month</button>
<button onclick="last2weeks()">Last 2 weeks</button>
<button onclick="currentWeek()">This Week</button>



 <div style='display: none;' id="currentWeek">
    <br>
    This Week
    <br>
    {{$currentWeek}}
    <br>
    @if($totalHours > $totalHoursTodoCurrentWeek)
    {{$totalHours}} of {{$totalHoursTodoCurrentWeek}} hours | You did more {{$totalHours - $totalHoursTodoCurrentWeek}} hours this week.
    @else 
    {{$totalHours}} of {{$totalHoursTodoCurrentWeek}} hours | You must report more {{$totalHoursTodoCurrentWeek - $totalHours}} hours this week.
    @endif
    <br>
    <br>

    <table>
    <tr>
{{-- 
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
    </th> --}}

    @for($b = $workHoursSettings->flextime_startDay-1; $b < $workHoursSettings->flextime_endDay; $b++)
        <th>{{date( 'D', strtotime( 'monday this week +'.$b.' days'))}}
            <br>
            {{date( 'd F', strtotime( 'monday this week +'.$b.' days'))}}
        </th>
    @endfor


    </tr>



    <tr>
    @foreach($totalsCurrentWeek as $dayCurrent)
        @if(is_numeric($dayCurrent))
            <td>{{$dayCurrent}} hours</td>
        @else
            <td>{{$dayCurrent}}</td>
        @endif
    @endforeach
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

    @for($b = $workHoursSettings->flextime_startDay-1; $b < $workHoursSettings->flextime_endDay; $b++)
        <th>{{date( 'D', strtotime( '-1 week monday this week +'.$b.' days'))}}
            <br>
            {{date( 'd F', strtotime( ' -1 week monday this week +'.$b.' days'))}}
        </th>
    @endfor


        <tr>
            @foreach($lastWeekTotals as $dayPastweek)
                @if(is_numeric($dayPastweek))
                    <td>{{$dayPastweek}} hours</td>
                @else
                    <td>{{$dayPastweek}}</td>
                @endif
            @endforeach
        </tr>
    
    </table>
    <br>
    Two weeks ago
    <br>
    {{$last2weeks}}
    <br>

    <table>
        <tr>
        
        @for($b = $workHoursSettings->flextime_startDay-1; $b < $workHoursSettings->flextime_endDay; $b++)
            <th>{{date( 'D', strtotime( '-2 week monday this week +'.$b.' days'))}}
                <br>
                {{date( 'd F', strtotime( ' -2 week monday this week +'.$b.' days'))}}
            </th>
        @endfor

        <tr>
            @foreach($last2WeeksTotals as $dayPast2week)
                @if(is_numeric($dayPast2week))
                    <td>{{$dayPast2week}} hours</td>
                @else
                    <td>{{$dayPast2week}}</td>
                @endif
            @endforeach
        </tr>
    
    </table>
    
    
    <br>
    {{$totalHours15days}} hours reported total in the last 2 weeks.
    <br>
    @if($totalHours15days > $hoursToReportPer15Days)
    {{$totalHours15days - $hoursToReportPer15Days}} hours overtime.
    @else
    {{$hoursToReportPer15Days}} hours left to report in the last two weeks.
    @endif
    <br>
    <br>
    {{$totalHoursDone15daysThisMonth}} of {{$totalHoursTodoPast2WeeksThisMonth}} hours done this month in the past two weeks
    @if($totalHoursDone15daysThisMonth > $totalHoursTodoPast2WeeksThisMonth)
        <br>
        You did more {{$totalHoursDone15daysThisMonth - $totalHoursTodoPast2WeeksThisMonth}} hours overtime.
    @endif

</div>

<div id="lastMonth" style="display: none;">
    <br>
    Previous Month
    <br>
<table>
    <tr>
        @foreach($daysPreviousMonth as $day)
            <th>{{date( 'D', strtotime($day->format('Y-m-d')))}}
                <br>
                {{date( 'd F', strtotime($day->format('Y-m-d')))}}
                <?php $countTr++ ?>
            </th>
            @if($day->format('w') == end($workingDays)) <!-- Assim que chega a sexta, acaba e começa uma nova table -->
                </tr>   <!-- encerra a tr dos headers -->

                        <tr>  <!-- começa as td -->
                            @for($b = $countTh; $b < $countTr; $b++) <!-- o $b assume sempre o ultimo valor de onde parou -->
                                <td>{{$daysPreviousMonthTotals[$b]}}</td>
                            @endfor
                            <?php $countTh = $b ?>
                        </tr> <!-- acaba as td -->
                </table> <!-- termina uma table -->
                <br>
                <table>  <!-- começa outra table -->
                <tr>
            @elseif(end($workingDays) != 5 && $countTr == count($daysPreviousMonth)) <!-- se tiver na ultimo dia e não for sexta -->
                </tr>   <!-- encerra a tr dos headers -->

                         <tr>  <!-- começa as td -->
                            @for($b = $countTh; $b < $countTr; $b++) <!-- o $b assume sempre o ultimo valor de onde parou -->
                                    <td>{{$daysPreviousMonthTotals[$b]}}</td>
                            @endfor
                            <?php $countTh = $b ?>
                        </tr> <!-- acaba as td -->
                    </table> 
                    <br>
                    <table> 
                    <tr>
            @endif
        @endforeach
       
    </tr>
</table>

{{$totalHoursDoneLastMonth}} of {{$totalHoursToDoLastMonth}} of hours done last month.
<br>
@if($totalHoursDoneLastMonth > $totalHoursToDoLastMonth)
    You have done {{$totalHoursDoneLastMonth - $totalHoursToDoLastMonth}} hours overtime last month.
@endif

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
function lastMonth() {
    if(document.getElementById("lastMonth").style.display == "none") {
        document.getElementById("lastMonth").style.display = "block";
    }
    else {
        document.getElementById("lastMonth").style.display = "none";
    }
}

</script>


</body>

</html>