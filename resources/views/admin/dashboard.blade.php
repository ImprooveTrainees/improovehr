@extends('layouts.template')

@section('title')
    Improove HR Tool
@endsection
@section('content')
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
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
    margin: 0 auto;
  }

  #external-events {
    float: left;
    width: 200px;
    padding: 35px 10px;
    border: 1px solid #ccc;
    background: #eee;
    text-align: center;
    margin-left: 5%;
    margin-top: 6%;
  }

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
    width: 65%;
  }

  #boxcalendar {
    margin: auto;
    height: 101%;
    width: 95%;
    border-radius: 8px;
  }

  #ferias{
    margin-left: 50px;
    width: 25%;
    height: 25%;
  }

  #teste{
    margin-left: 0px;
    width: 100%;
    height: 100%;
  }

</style>
</head>
<body>
<div class="shadow p-1 bg-white" id="boxcalendar">
  <div id='wrap'>

    <!-- <div id='external-events'> -->

    <!-- <div class="shadow p-3 mb-5 bg-white rounded">Regular shadow</div>
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
<div id="teste">
<div class="shadow p-3 mb-5 bg-white rounded" id="ferias">
  <div class="row">
    <div class="col">
      Holidays
    </div>
  </div>
  </div>
  <div class="shadow p-3 mb-5 bg-white rounded" id="ferias">
  <div class="row">
    <div class="col">
      Absences
    </div>
  </div>
  </div>
  <div class="shadow p-3 mb-5 bg-white rounded" id="ferias">
  <div class="row">
    <div class="col">
      Time Accomplished
            </div>
        </div>
    </div>
</div>
</div>

    <div style='clear:both'></div>

</div>

  <!-- <section id="team">
        <div class="container my-3 py-5 text-center">
            <div class="row mb-5">
                <div class="col">
                    <h1>Our Team</h1>
                        <p class="mt-3">nmnnnnnn</p>
                    </div>
                </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <img src="../../../public/img/cristian-newman-f49XhYbpiA0-unsplash.jpg" alt="" class="img-fluid rounded-circle w-50 mb-3">
                            <h3>Susan Williams</h3>
                                <h5>Manager</h5>
                                    <p>jjjjjjjjjjjjjjjjjjjj</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

</div>

</body>
</html>

</div>
<!-- END Page Content -->

@endsection

@section('scripts')

@endsection
