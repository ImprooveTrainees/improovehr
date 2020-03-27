@extends('layouts.template')

@section('title')
    Improove HR Tool
@endsection

@section('sidebarhome')
active
@endsection

@section('content')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Simple table teste</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <tbody class="table">
                        <thead class="text-primary">
                            <th>something</th>
                            <th>something</th>
                            <th>something</th>
                            <th>something</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>12</td>
                                <td>12</td>
                                <td>12</td>
                            </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Page Content -->
<div class="content">

        <!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='{{asset('assets/fullcalendar/packages/core/main.css')}}' rel='stylesheet' />
<link href='{{asset('assets/fullcalendar/packages/daygrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('assets/fullcalendar//packages/timegrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('assets/fullcalendar//packages/list/main.css')}}' rel='stylesheet' />
<script src='{{asset('assets/fullcalendar//packages/core/main.js')}}'></script>
<script src='{{asset('assets/fullcalendar//packages/interaction/main.js')}}'></script>
<script src='{{asset('assets/fullcalendar//packages/daygrid/main.js')}}'></script>
<script src='{{asset('assets/fullcalendar//packages/timegrid/main.js')}}'></script>
<script src='{{asset('assets/fullcalendar//packages/list/main.js')}}'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendarInteraction.Draggable

    /* initialize the external events
    -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    new Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText.trim()
        }
      }
    });

    //// the individual way to do it
    // var containerEl = document.getElementById('external-events-list');
    // var eventEls = Array.prototype.slice.call(
    //   containerEl.querySelectorAll('.fc-event')
    // );
    // eventEls.forEach(function(eventEl) {
    //   new Draggable(eventEl, {
    //     eventData: {
    //       title: eventEl.innerText.trim(),
    //     }
    //   });
    // });

    /* initialize the calendar
    -----------------------------------------------------------------*/

    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      navLinks:true,
      eventLimit:true,
      selectable:true,
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function(arg) {
        // is the "remove after drop" checkbox checked?
        if (document.getElementById('drop-remove').checked) {
          // if so, remove the element from the "Draggable Events" list
          arg.draggedEl.parentNode.removeChild(arg.draggedEl);
        }
      }
    });
    calendar.render();

  });

</script>
<style>

  body {
    margin-top: 40px;
    font-size: 15px;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  }

  #wrap {
    width: 100%;
    margin: auto;
  }

  /* #external-events {
    float: left;
    width: 200px;
    padding: 35px 10px;
    border: 1px solid #ccc;
    background: #eee;
    text-align: center;
    margin-left: 5%;
    margin-top: 6%;
  } */

  #external-events h4 {
    font-size: 16px;
    margin-top: 0;
    padding-top: 1em;
  }

  #external-events .fc-event {
    margin: 10px 0;
    cursor: pointer;
  }

  #external-events p {
    margin: 1.5em 0;
    font-size: 11px;
    color: #666;
  }

  #external-events p input {
    margin: 0;
    vertical-align: middle;
  }

  #calendar {
    float: right;
    width: 55%;
    border-radius: 8px;
    margin-top: -20px;
  }

  #multi-item-example {
    margin-top: 630px;
    width: 36%;
    margin-left: -248px;
    position: absolute;
  }

  .dot1 {
  height: 75px;
  width: 75px;
  border-radius: 50%;
  display: inline-block;
  border: 1px solid #00ff3a61;
  margin-left: -140px;
  margin-top: 15px;
  background-color: #90ee90;
}

.dot2 {
  height: 75px;
  width: 75px;
  border-radius: 50%;
  display: inline-block;
  border: 1px solid #dc3545;
  margin-left: -140px;
  margin-top: 15px;
  background-color: #d26a5c;;
}

#label3 {
  margin-top: 12%;
  color: white;
  font-size: 35px;
  font-family: monospace;
}

#ptotalabsences {
  margin-top: -104px;
  color: white;
  font-size: 35px;
  font-family: monospace;
  margin-left: -137px;
}

#timeaccomplished {
  font-variant-caps: all-small-caps;
  font-size: large;
}

/* Style all font awesome icons */
#social {
    padding: 10px;
    width: 35px;
    text-align: center;
    text-decoration: none;
    border-radius: 50%;
  }
  
  /* Add a hover effect if you want */
  .fa:hover {
    opacity: 0.7;
  }
  
  /* Set a specific color for each brand */
  
  /* Facebook */
  .fa-facebook {
    background: #3B5998;
    color: white;
  }

  .fa-linkedin {
    background: #007bb5;
    color: white;
  }

</style>
</head>
<body>
<div class="shadow p-1 bg-white" id="calendar">
  <div id='wrap'>

    <!-- <div id='external-events'>

    <div class="shadow p-3 mb-5 bg-white rounded">Regular shadow</div>
      <h4>Draggable Events</h4> -->

      <div id='external-events-list'>
        <!-- <div class='fc-event'>Faltas</div>
        <div class='fc-event'>Férias</div> -->
      </div>

      <!-- <p>
        <input type='checkbox' id='drop-remove' />
        <label for='drop-remove'>remove after drop</label>
      </p> -->

    </div>

    <div id='calendar'></div>

    <div style='clear:both'></div>

  </div>

  <div id="allboxes">
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
    <div class="carousel-item active">

      <div class="row">
        <div class="col-md-4">
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
              <p class="card-text">Vacations</p>
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
      </div>

    </div>
    <!--/.First slide-->

    <!--Second slide-->
    <div class="carousel-item">

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

    </div>
    <!--/.Second slide-->

    <!--Third slide-->
    <div class="carousel-item">

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

    </div>
    <!--/.Third slide-->

  </div>
  <!--/.Slides-->

</div>
<!--/.Carousel Wrapper-->


</div>

<script>
var d = new Date();
document.getElementById("currentyear1").innerHTML = d.getFullYear();
</script>

<script>
var d = new Date();
document.getElementById("currentyear2").innerHTML = d.getFullYear();
</script>

</body>
</html>

</div>
<!-- END Page Content -->

@endsection

@section('scripts')

@endsection
