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


  <div id="allboxes">
<!-- Calendar Begin -->
    <h3>Improove Calendar</h3>
    
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
            defaultView: 'dayGridMonth',
            height: 580,
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
                        backgroundColor: 'yellow',
                        borderColor: 'black',
                        @endif 
                        
                        @if($event->Type == "Contract Begin")
                        title : '{{ $event->Name }}'+ "'"+'s company' + "'" +  's birthday!',
                        backgroundColor: 'green',
                        borderColor: 'black',
                        textColor: 'white',
                        @endif

                        @if($event->Type == "Absence")
                        title : '{{ $event->Name }}' + " | " + '{{ $event->{"Absence Motive"} }}',
                        @endif

                        @if($event->Type == "Absence" && $event->{"Absence Type"} == 1)
                        title : '{{ $event->Name }}' + " | " + 'Vacations',
                        backgroundColor: '#57db39',
                        borderColor: 'black',
                        textColor: 'black',
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


  <div class="shadow p-1 bg-white" id="box1">
  <div class="container">
  <div class="row">
  <div class="col">
  <span class="dot1">
  <label id="label3">{{$vacationDaysAvailable}}</label>
  </span>
  <p id="pholidays">Days Available</p>
  <p id="ptotal">A total of {{$vacations_total}} days</p>
  <p id="year1">Year of<p id="currentyear1"></p></p>
    </div>
  </div>
</div>
</div>

<div class="shadow p-1 bg-white" id="box2">
<div class="row">
    <div class="col">
    <p class="dot2"></p>
    <p id="ptotalabsences">{{$diasAusencia}}</p>
    <p id="pabsences">Absence Days</p>
    <p id="year2">Year of<p id="currentyear2"></p></p>
    </div>
  </div>
</div>

<div class="shadow p-1 bg-white" id="box3">
<div class="row">
    <div class="col">
    <p id="timeaccomplished">Time Accomplished</p>
    </div>
  </div>
</div>
</div>

<div class="container my-4" id="carouselbox">

<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

  <!--Controls-->
  <div class="controls-top">
    <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
    <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
  </div>
  <!--/.Controls-->

  <!--Indicators-->
  <ol class="carousel-indicators">
    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
    <li data-target="#multi-item-example" data-slide-to="1"></li>
    <li data-target="#multi-item-example" data-slide-to="2"></li>
  </ol> 
  <!--/.Indicators-->

  <!--Slides-->
  <div class="carousel-inner" id="allboxes2" role="listbox">

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
  <!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->


</div>


</div>

<!-- END Page Content -->

@endsection

@section('scripts')

@endsection
