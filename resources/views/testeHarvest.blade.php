@extends('layouts.template')

@section('title')
    Improove HR - Flex-Time
@endsection

@section('sidebarflextime')
active
@endsection

@section('opensidebar')
open
@endsection

@section('content')

<div class="shadow p-1 bg-white cardbox1">
    <div class="shadow p-1 bg-white cardbox2 flexstyle">
        <h6 id="flexh6">This Week</h6>
        <div id="flexhours">
            <h1 style="color: #ff0000">{{$hoursReportedTotal}}</h1>
            <h4>of</h4>
            <h1 style="color: #02ca02ec">{{$monthlyHoursWorkDays}}</h1>
            <h4>Hours</h4>
        </div>
        <div id="flexleft">
            <h6>Report more</h6>
            <h3 style="color: #ff0000">{{$hoursLeftReport}}</h3>
            <h6>Hours</h6>
        </div>
    </div>

    <div id="flexmonths">
        <h1>{{$month}}</h1>
    </div>


    {{-- {{$month}}

<img src="{{$harvestProfile->avatar_url}}" style="width: 60px; height: 60px">
{{$harvestProfile->first_name}}
{{$harvestProfile->last_name}}

 {{$harvestProfile->email}} --}}

 {{-- Total hours reported this month: {{$hoursReportedTotal}} of {{$monthlyHoursWorkDays}}
 <br>
 You must report more {{$hoursLeftReport}} hours this month.
 <br> --}}

<div id="flexbuttons">
    <button  class="form-group btn btn-outline-primary" id="lastMonth2" onclick="showMonth()">Last Month</button>
    <button  class="form-group btn btn-outline-primary" id="lat2weeks2" onclick="show2weeks()">Last 2 weeks</button>
    <button  class="form-group btn btn-outline-primary" id="currentWeek2" onclick="showWeek()">This Week</button>
</div>



{{-- Last Month Table --}}
<div id="lastMonth">
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable">
            <thead>
                <tr>
                    @foreach($daysPreviousMonth as $day)
                    <th class="d-sm-table-cell">
                        {{date( 'D', strtotime($day->format('Y-m-d')))}}
                        <br>
                        {{date( 'd F', strtotime($day->format('Y-m-d')))}}
                        <?php $countTr++ ?>
                    </th>
                    @if($day->format('w') == 5) <!-- Assim que chega a sexta, acaba e começa uma nova table -->
                </tr>
            </thead>
            <tbody>
                    <tr>  <!-- começa as td -->
                        @for($b = $countTh; $b < $countTr; $b++) <!-- o $b assume sempre o ultimo valor de onde parou -->
                            <td>{{$daysPreviousMonthTotals[$b]}} Hours</td>
                        @endfor
                        <?php $countTh = $b ?>
                    </tr> <!-- acaba as td -->
                </tbody>
            </table> <!-- termina uma table -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable">  <!-- começa outra table -->
                <thead>
                <tr>
                @elseif($day->format('w') != 5 && $countTr == count($daysPreviousMonth)) <!-- se tiver na ultimo dia e não for sexta -->
                </tr>   <!-- encerra a tr dos headers -->
                </thead>
                    <tr>  <!-- começa as td -->
                        @for($b = $countTh; $b < $countTr; $b++) <!-- o $b assume sempre o ultimo valor de onde parou -->
                                <td>{{$daysPreviousMonthTotals[$b]}} Hours</td>
                        @endfor
                        <?php $countTh = $b ?>
                    </tr> <!-- acaba as td -->
                </table>
                @endif
            @endforeach
            <h5>{{$totalHoursDoneLastMonth}} of {{$totalHoursToDoLastMonth}} of hours done last month</h5>

    {{-- @if($totalHoursDoneLastMonth > $totalHoursToDoLastMonth)
        <h3>You have done {{$totalHoursDoneLastMonth - $totalHoursToDoLastMonth}} hours overtime last month.</h3>
    @endif --}}
    </div>
</div>
{{-- END Last Month Table --}}


{{-- Last 2 Weeks Table --}}
<div id="last2weeks">
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable">
            <thead>
                <tr>
                    <th class="d-sm-table-cell">{{date( 'D', strtotime( '-1 week monday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( '-1 week monday this week'))}}
                    </th>
                    <th class="d-sm-table-cell">{{date( 'D', strtotime( '-1 week tuesday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( '-1 week tuesday this week'))}}
                    </th>
                    <th class="d-sm-table-cell">{{date( 'D', strtotime( '-1 week wednesday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( '-1 week wednesday this week'))}}
                    </th>
                    <th class="d-sm-table-cell">{{date( 'D', strtotime( '-1 week thursday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( '-1 week thursday this week'))}}
                    </th>
                    <th class="d-sm-table-cell">{{date( 'D', strtotime( '-1 week friday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( '-1 week friday this week'))}}
                    </th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($lastWeekTotals as $dayPastweek)
                        @if(is_numeric($dayPastweek))
                            <td>{{$dayPastweek}} hours</td>
                        @else
                            <td>{{$dayPastweek}}</td>
                        @endif
                    @endforeach
                </tr>
                </tbody>
            </table> <!-- termina uma table -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable">  <!-- começa outra table -->
                <thead>
                    <tr>
                        <th class=" d-sm-table-cell">{{date( 'D', strtotime( '-2 week monday this week'))}}
                            <br>
                            {{date( 'd F', strtotime( '-2 week monday this week'))}}
                        </th>
                        <th class=" d-sm-table-cell">{{date( 'D', strtotime( '-2 week tuesday this week'))}}
                            <br>
                            {{date( 'd F', strtotime( '-2 week tuesday this week'))}}
                        </th>
                        <th class=" d-sm-table-cell">{{date( 'D', strtotime( '-2 week wednesday this week'))}}
                            <br>
                            {{date( 'd F', strtotime( '-2 week wednesday this week'))}}
                        </th>
                        <th class=" d-sm-table-cell">{{date( 'D', strtotime( '-2 week thursday this week'))}}
                            <br>
                            {{date( 'd F', strtotime( '-2 week thursday this week'))}}
                        </th>
                        <th class=" d-sm-table-cell">{{date( 'D', strtotime( '-2 week friday this week'))}}
                            <br>
                            {{date( 'd F', strtotime( '-2 week friday this week'))}}
                        </th>
                    </tr>

                </thead>
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

            <h5>{{$totalHours15days}} hours reported total in the last 2 weeks.</h5>
            @if($totalHours15days > $hoursToReportPer15Days)
            <h5>{{$totalHours15days - $hoursToReportPer15Days}} hours overtime.</h5>
            {{-- @else
            {{$hoursToReportPer15Days}} hours left to report in the last two weeks. --}}
            @endif

            <h5>{{$totalHoursDone15daysThisMonth}} of {{$totalHoursTodoPast2WeeksThisMonth}} hours done this month in the past two weeks</h5>
            @if($totalHoursDone15daysThisMonth > $totalHoursTodoPast2WeeksThisMonth)
                <h5>You did more {{$totalHoursDone15daysThisMonth - $totalHoursTodoPast2WeeksThisMonth}} hours overtime.</h5>
            @endif
    </div>
</div>
{{-- END Last 2 Weeks Table --}}


{{-- Last Week Table --}}
<div id="currentWeek">
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-buttons class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
        <table class="table table-bordered table-striped table-vcenter js-dataTable">
            <thead>
                <tr>
                    <th class=" d-sm-table-cell">{{date( 'D', strtotime( 'monday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( 'monday this week'))}}
                    </th>
                    <th class=" d-sm-table-cell">{{date( 'D', strtotime( 'tuesday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( 'tuesday this week'))}}
                    </th>
                    <th class=" d-sm-table-cell">{{date( 'D', strtotime( 'wednesday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( 'wednesday this week'))}}
                    </th>
                    <th class=" d-sm-table-cell">{{date( 'D', strtotime( 'thursday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( 'thursday this week'))}}
                    </th>
                    <th class=" d-sm-table-cell">{{date( 'D', strtotime( 'friday this week'))}}
                        <br>
                        {{date( 'd F', strtotime( 'friday this week'))}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @foreach($totalsCurrentWeek as $dayCurrent)
                        @if(is_numeric($dayCurrent))
                            <td>{{$dayCurrent}} hours</td>
                        @else
                            <td>{{$dayCurrent}}</td>
                        @endif
                    @endforeach
                </tr>
                </tbody>
            </table> <!-- termina uma table -->

            @if($totalHours > $totalHoursTodoCurrentWeek)
            <h5>{{$totalHours}} of {{$totalHoursTodoCurrentWeek}} hours | You did more {{$totalHours - $totalHoursTodoCurrentWeek}} hours this week.</h5>
            @else
            <h5>{{$totalHours}} of {{$totalHoursTodoCurrentWeek}} hours | You must report more {{$totalHoursTodoCurrentWeek - $totalHours}} hours this week.</h5>
            @endif
    </div>
</div>
{{-- END Last Week Table --}}

{{-- END OF CARDBOX1 --}}
</div>
@endsection
