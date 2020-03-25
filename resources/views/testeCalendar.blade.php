<html>
<head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
<link href='assets/fullcalendar/core/main.css' rel='stylesheet' />
<link href='assets/fullcalendar/daygrid/main.css' rel='stylesheet' />

<script src='assets/fullcalendar/core/main.js'></script>
<script src='assets/fullcalendar/daygrid/main.js'></script>
<script src='assets/fullcalendar/interaction/main.js'></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous">
</script>

</head>



<body>
    
    <h3>Calendar</h3>
    
    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid' ],
            defaultView: 'dayGridMonth',
            selectable: true,
            height: 580,
            select: function(info) {
            alert('De ' + info.startStr + ' a ' + info.endStr);
            var dataClicada =  info.date.getFullYear().toString() + (info.date.getMonth()+1).toString() + info.date.getDate().toString(); //aqui vai buscar a data clicada 
            },
          events : [
                    @foreach($events as $event)
                    {   
                        @if($event->Type == "Birthday")
                        title : '{{ $event->Name }}'+ "'"+'s birthday!',
                        @endif 
                        
                        @if($event->Type == "Contract Begin")
                        title : '{{ $event->Name }}'+ "'"+'s company' + "'" +  's birthday!',
                        @endif

                        @if($event->Type == "Absence")
                        title : '{{ $event->Name }}' + " | " + '{{ $event->{"Absence Motive"} }}',
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



</body>



</html>