@extends('layouts.template')

@section('title')
    Improove HR - Flex-Time
@endsection


@section('content')
    <div class="shadow p-1 bg-white cardbox1">
        <div class="shadow p-1 bg-white cardbox2 flexstyle">
                <h6 id="flexh6">This Week</h6>
                <div id="flexhours">
                    <h1 style="color: #ff0000">30</h1>
                    <h4>of</h4>
                    <h1 style="color: #02ca02ec">40</h1>
                    <h4>Hours</h4>
                </div>
        </div>
        <div id="flexmonths">
            <h1>FEBRUARY</h1>
        </div>
        <div id="flexmonths2">
            <h1>Example</h1>
        </div>

        <div id="demo" class="carousel slide" data-interval="false">

            <!-- Indicators -->
            <ul class="carousel-indicators">
              <li data-target="#demo" data-slide-to="0" class="active"></li>
              <li data-target="#demo" data-slide-to="1"></li>
              <li data-target="#demo" data-slide-to="2"></li>
            </ul>

            <!-- The slideshow -->
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="img/users/Admin.jpg" alt="Los Angeles" width="1100" height="500">
              </div>
              <div class="carousel-item">
                <img src="img/users/marta.jpg" alt="Chicago" width="1100" height="500">
              </div>
              <div class="carousel-item">
                <img src="img/users/ambrosio.jpg" alt="New York" width="1100" height="500">
              </div>
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
              <span class="carousel-control-next-icon"></span>
            </a>
          </div>


    </div>
@endsection
