<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            /* Style tab links */
            .tablink {
            background-color: #555;
            color: white;
            float: center;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 17px;
            width: 25%;
            }

            .tablink:hover {
            background-color: #777;
            }

            /* Style the tab content (and add height:100% for full page content) */
            .tabcontent {
            color: black;
            display: center;
            text-align: center;
            padding: 100px 20px;
            height: 100%;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
           @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">

                <button class="tablink" onclick="openPage('Vacations', this, 'red')">Vacations</button>
                <button class="tablink" onclick="openPage('Absences', this, 'green')" id="defaultOpen">Absences</button>

                <div id="Vacations" class="tabcontent">
                    <table>
                    <tr>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Approval</th>
                    </tr>

                @for($i=0;$i<count($array_vacations);$i+=3)
                    <tr>
                    <td> {{$array_vacations[$i]}} </td>
                    <td> {{$array_vacations[$i+1]}} </td>
                    <td> {{$array_vacations[$i+2]}} </td>
                    </tr>
                @endfor

                    </table>

                    <button type="button" onclick="window.location='{{ url("createVacations") }}'">ADD NEW VACATION</button>


                </div>

                <div id="Absences" class="tabcontent">
                    <table>
                    <tr>
                        <th>Start Date and Time</th>
                        <th>End Date and Time</th>
                        <th>Approval</th>
                        <th>Attachment</th>
                        <th>Motive</th>
                    </tr>

                    @for($i=0;$i<count($array_absences);$i+=5)
                        <tr>
                        <td> {{$array_absences[$i]}} </td>
                        <td> {{$array_absences[$i+1]}} </td>
                        <td> {{$array_absences[$i+2]}} </td>
                        <td> {{$array_absences[$i+3]}} </td>
                        <td> {{$array_absences[$i+4]}} </td>
                        </tr>
                    @endfor


                    </table>

                    <button>Add New Absence</button>

                </div>



                </div>

                <p class="msgVacation">{{ session('msgVacation') }}</p>

            </div>

        </div>
    </body>
    <script>
            function openPage(pageName,elmnt,color) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            document.getElementById(pageName).style.display = "block";
            elmnt.style.backgroundColor = color;
            }

            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
            </script>
</html>
