@extends('layouts.template')

@section('title')
    Improove HR Tool
@endsection

@section('sidebarhome')
active
@endsection

@section('content')

<!-- Page Content -->
<div class="content">

    {{-- Info Boxes --}}
        <div id="allboxes">
            {{-- Box 1 --}}
            <div class="shadow bg-white" id="box1">
                <div id="pholidays2">
                    <p>Days Available</p>
                    <hr>
                </div>

                <span class="dot1">
                    <label id="label3">{{$vacationDaysAvailable}}</label>
                </span>
                <div id="pholidays">
                    <p>A total of</p>
                    <hr>
                </div>

                <div id="pTotalHolidays">
                    <p id="ptotal">{{$vacations_total}} days</p>
                </div>
                <div id="currentYear1">
                    <p id="year1">Year of</p>
                    <p id="currentyear1"></p>
                </div>

            </div>
            {{-- Box 2 --}}
            <div class="shadow p-1 bg-white" id="box2">
                <div id="pabsences">
                    <p>Absence Days</p>
                    <hr>
                </div>
                <div id="dotAbsences">
                        <p class="dot2"></p>
                        <p id="ptotalabsences">{{$diasAusencia}}</p>
                </div>

                <div id="currentYear1">
                    <p id="year2">Year of</p>
                    <p id="currentyear2"></p>
                </div>

            </div>
            {{-- Box 3 --}}
            <div class="shadow p-1 bg-white" id="box3">
                <div id="timeAll2">
                <div id="timeAll">
                    <p>Time Accomplished</p>
                    <hr>
                </div>
                <p id="timeaccomplished">30  of 40 hours</p>
                </div>
            </div>

        </div>


    {{-- Carousel Box --}}
    <div id="multi-item-example" class="carousel carousel-multi-item" data-ride="carousel">
    <!--White Box-->
    <div class="shadow bg-white carousel-inner" class="carousel-inner" id="allboxes2" role="listbox">
        <!--Controls-->
        <div class="controls-top">
            <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
            <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
        </div>
        <!--/.Controls-->
        <!--First slide-->
        {{-- <div class="carousel-item active">  --}}

        {{-- <div class="row"> <!-- Inicio bloco com 3 sliders --> --}}

            {{-- <div class="col-md-4">
            <div class="card mb-2"> --}}
                {{-- <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(34).jpg"
                alt="Card image cap"> --}}
                {{-- <div class="card-body">
                <h4 class="card-title">Card title</h4>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                <a class="btn btn-primary">Button</a>
                </div> --}}
            {{-- </div>
            </div> --}}

        <?php echo $msg?>

        {{-- </div> --}}

        {{-- </div> --}}
        <!--/.First slide | Fim 1 bloco-->

        <!--Second slide-->
        {{-- <div class="carousel-item">

        <div class="row">
            <div class="col-md-4">
            <div class="card mb-2">
                <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg"
                alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Name</h5>
                <p class="card-text">Vacations</p>
                <a href="http://www.facebook.com" class="fa fa-facebook" id="social"></a>
                <a href="http://www.linkedin.com" class="fa fa-linkedin" id="social"></a>
                <!-- <a class="btn btn-primary">Button</a> -->
                </div>
            </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
            <div class="card mb-2">
                <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(27).jpg"
                alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Name</h5>
                <p class="card-text">Happy Birthday!</p>
                <a href="http://www.facebook.com" class="fa fa-facebook" id="social"></a>
                <a href="http://www.linkedin.com" class="fa fa-linkedin" id="social"></a>
                <!-- <a class="btn btn-primary">Button</a> -->
                </div>
            </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
            <div class="card mb-2">
                <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg"
                alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Name</h5>
                <p class="card-text">Absence</p>
                <a href="http://www.facebook.com" class="fa fa-facebook" id="social"></a>
                <a href="http://www.linkedin.com" class="fa fa-linkedin" id="social"></a>
                <!-- <a class="btn btn-primary">Button</a> -->
                </div>
            </div>
            </div>
        </div>

        </div> --}}
        <!--/.Second slide-->

        <!--Third slide-->
        {{-- <div class="carousel-item">

        <div class="row">
            <div class="col-md-4">
            <div class="card mb-2">
                <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(20).jpg"
                alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Name</h5>
                <p class="card-text">Happy Birthday!</p>
                <a href="http://www.facebook.com" class="fa fa-facebook" id="social"></a>
                <a href="http://www.linkedin.com" class="fa fa-linkedin" id="social"></a>
                <!-- <a class="btn btn-primary">Button</a> -->
                </div>
            </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
            <div class="card mb-2">
                <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(10).jpg"
                alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Name</h5>
                <p class="card-text">Absence</p>
                <a href="http://www.facebook.com" class="fa fa-facebook" id="social"></a>
                <a href="http://www.linkedin.com" class="fa fa-linkedin" id="social"></a>
                <!-- <a class="btn btn-primary">Button</a> -->
                </div>
            </div>
            </div>

            <div class="col-md-4 clearfix d-none d-md-block">
            <div class="card mb-2">
                <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Avatars/img%20(27).jpg"
                alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Name</h5>
                <p class="card-text">Absence</p>
                <a href="http://www.facebook.com" class="fa fa-facebook" id="social"></a>
                <a href="http://www.linkedin.com" class="fa fa-linkedin" id="social"></a>
                <!-- <a class="btn btn-primary">Button</a> -->
                </div>
            </div>
            </div>
        </div>

        </div> --}}
        <!--/.Third slide-->

    </div>
    <!--/.Box White-->
    </div>
    {{-- END Carousel --}}


    {{-- Begin Calendar Box --}}
    <div id="calendarDiv">
        <!-- Calendar Begin -->
        {{-- p-1 class to have lines on calendar --}}
        <div class="shadow bg-white" id='calendar'></div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
                    defaultView: 'dayGridMonth',
                    height: 800,
                    header: {
                    left: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                    right: 'prevYear,prev,next,nextYear'
                    },
                    selectable: false,
                    // select: function(info) {
                    // alert('De ' + info.startStr + ' a ' + info.endStr);
                    // var dataClicada =  info.date.getFullYear().toString() + (info.date.getMonth()+1).toString() + info.date.getDate().toString(); //aqui vai buscar a data clicada
                    // },
                  events : [
                            @foreach($events as $event)
                            {
                                @if($event->Type == "Birthday")
                                title : '{{ $event->Name }}'+ "'"+'s birthday!',
                                backgroundColor: 'orange',
                                borderColor: 'orange',
                                textColor: 'white',
                                @endif

                                @if($event->Type == "Contract Begin")
                                title : '{{ $event->Name }}'+ "'"+'s company' + "'" +  's birthday!',
                                backgroundColor: 'dodgerblue',
                                borderColor: 'dodgerblue',
                                textColor: 'white',
                                @endif

                                @if($event->Type == "Absence")
                                title : '{{ $event->Name }}' + " | " + '{{ $event->{"Absence Motive"} }}',
                                backgroundColor: 'red',
                                borderColor: 'red',
                                textColor: 'white',
                                @endif

                                @if($event->Type == "Absence" && $event->{"Absence Type"} == 1)
                                title : '{{ $event->Name }}' + " | " + 'Vacations',
                                backgroundColor: 'limegreen',
                                borderColor: 'limegreen',
                                textColor: 'white',
                                @endif

                                start : '{{ $event->Date }}',
                                end : '{{ $event->{"DateEnd Absence"} }}',

                            },
                            @endforeach
                        ],

                });

                calendar.render();
              });
            </script>

        <!-- Calendar end -->
        </div>

        {{-- Labels --}}
        <div id="allLabels">

        </div>

{{-- END Container --}}
</div>

<script>
var d = new Date();
document.getElementById("currentyear1").innerHTML = d.getFullYear();

var d = new Date();
document.getElementById("currentyear2").innerHTML = d.getFullYear();
</script>

<!-- END Page Content -->

@endsection

@section('scripts')

@endsection
