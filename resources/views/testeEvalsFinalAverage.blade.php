@extends('layouts.template')

@section('title')
    Improove HR - Show Final Average
@endsection

@section('sidebarFinalAverage')
active
@endsection

@section('openEvaluations')
    open
@endsection

@section('content')


<div class="shadow p-1 bg-white cardbox1">
    <div class="centerStyle">
        <h4>Select a user to see his final average results of a chosen year</h4>
    </div>
    <div class="">
        <form class="form-group finalAverage" action="/finalCalculus" method="post">
            @csrf

                <div class="showFinalAverageGrid">
                    <select class="form-control" id="exampleFormControlSelect2" name="idUser">
                        @foreach ($allUsers as $user)
                            <option value={{$user->id}}>{{$user->name}}</option>
                        @endforeach
                    </select>
                    <select class="form-control" id="exampleFormControlSelect2" name="chosenYear">
                        @foreach ($yearsArray as $year)
                            <option value={{$year}}>{{$year}}</option>
                        @endforeach
                    </select>
                        <button class="btn btn-outline-success" type="submit">Show</button>
                </div>

        </form>
    </div>


    @if(count($arrayAveragesTable) != 0)
            <table id="tableFormat" class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th id="tableStyle" class="bg-info" scope="col"><b>Total Potencial</b></th>
                    <th class="table-dark" scope="col"><b>Total Performance</b></th>
                </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($arrayAveragesTable); $i+=3)
                        <tr>
                            <th scope="row">{{$arrayAveragesTable[$i]}}</th>
                            <td class="table-info">{{$arrayAveragesTable[$i+1]}}</td>
                            <td class="table-secondary">{{$arrayAveragesTable[$i+2]}}</td>
                        </tr>
                        @endfor
                        <tr class="table-Success">
                            <th class="" scope="row">Average Results</th>
                            <td class=""><b>{{$resultPotential}}</b></td>
                            <td class=""><b>{{$resultPerformance}}</b></td>
                        </tr>
                </tbody>
            </table>

        <div class="chartStyle">
            <div id="myChart"></div>
        </div>

        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>

            window.onload = function () {

        var chart = new CanvasJS.Chart("myChart", {
            animationEnabled: true,
            title:{
                fontColor: "#a7b530",
                fontFamily: "Helvetica",
                horizontalAlign: "center",
                text: "Average Results Graph"
            },
            axisX: {
                title:"Potential",
                titleFontColor: "blue",
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

        <p id="errorMsg" class="alert {{ Session::get('alert-class', 'alert-warning') }}">{{ Session::get('msgError') }}</p>

    @endif

</div>
    @endsection
</body>
</html>
