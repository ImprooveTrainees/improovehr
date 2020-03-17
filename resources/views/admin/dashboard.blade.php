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
    width: 65%;
    border-radius: 8px;
    margin-top: -3%;
  }

  #box {
    margin: 30px;
    margin-left: 65px;
    width: 25%;
    height: 25%;
    border-radius: 8px;
    text-align: center;
  }

  #box1 {
    margin-left: 65px;
    width: 25%;
    height: 25%;
    border-radius: 8px;
    margin-top: 50px;
    text-align: center;
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


  <div class="shadow p-1 bg-white" id="box">
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

<div class="shadow p-1 bg-white" id="box1">
<div class="row">
    <div class="col">
      Absences

        <p>{{$diasAusencia}}</p>

    </div>
  </div>
</div>

<div class="shadow p-1 bg-white" id="box1">
<div class="row">
    <div class="col">
      Time Accomplished
    </div>
  </div>
</div>

</body>
</html>

</div>
<!-- END Page Content -->

@endsection

@section('scripts')

@endsection
