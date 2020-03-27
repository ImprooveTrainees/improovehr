@extends('layouts.template')

@section('title')
    Improove HR Tool
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
      Holidays
    <p>AVAILABLE : {{$vacationDaysAvailable}}</p>
      <p>TOTAL : {{$vacations_total}}</p>
    </div>
  </div>
</div>
</div>

<div class="shadow p-1 bg-white" id="box2">
<div class="row">
    <div class="col">
      Absences

        <p>{{$diasAusencia}}</p>

    </div>
  </div>
</div>

<div class="shadow p-1 bg-white" id="box3">
<div class="row">
    <div class="col">
      Time Accomplished
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
  <div class="carousel-inner" role="listbox">

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
            <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(60).jpg"
              alt="Card image cap">
            <div class="card-body">
              <h4 class="card-title">Card title</h4>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                card's content.</p>
              <a class="btn btn-primary">Button</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 clearfix d-none d-md-block">
          <div class="card mb-2">
            <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(47).jpg"
              alt="Card image cap">
            <div class="card-body">
              <h4 class="card-title">Card title</h4>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                card's content.</p>
              <a class="btn btn-primary">Button</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 clearfix d-none d-md-block">
          <div class="card mb-2">
            <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/City/4-col/img%20(48).jpg"
              alt="Card image cap">
            <div class="card-body">
              <h4 class="card-title">Card title</h4>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                card's content.</p>
              <a class="btn btn-primary">Button</a>
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
            <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(53).jpg"
              alt="Card image cap">
            <div class="card-body">
              <h4 class="card-title">Card title</h4>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                card's content.</p>
              <a class="btn btn-primary">Button</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 clearfix d-none d-md-block">
          <div class="card mb-2">
            <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(45).jpg"
              alt="Card image cap">
            <div class="card-body">
              <h4 class="card-title">Card title</h4>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                card's content.</p>
              <a class="btn btn-primary">Button</a>
            </div>
          </div>
        </div>

        <div class="col-md-4 clearfix d-none d-md-block">
          <div class="card mb-2">
            <img class="card-img-top" src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(51).jpg"
              alt="Card image cap">
            <div class="card-body">
              <h4 class="card-title">Card title</h4>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                card's content.</p>
              <a class="btn btn-primary">Button</a>
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
