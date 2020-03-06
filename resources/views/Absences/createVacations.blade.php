@extends('layouts.template')

@section('title')
    Improove HR - Personal Info
@endsection

@section('content')
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

                <form action="/absences" method="POST" class="action">
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
            <a href="/absences">Back</a>

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
@endsection

