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

                    <h1>CREATE A NEW VACATION</h1>

                </div>

                <div class="wrapper">

                <form action="/testeAbsences" method="POST" class="action">
                    @csrf

                    <label for="start_date" >Start Date </label>
                    <input type="date" id="start_date" name="start_date">
                    <label for="end_date">End Date </label>
                    <input type="date" id="end_date" name="end_date">

                    <input type="hidden" value=1 name="op">

                    <input type="submit" value="ADD VACATION">

                </form>



                </div>

            </div>
            <br><br>
            <a href="/testeAbsences">Back</a>

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