@extends('layouts.template')

@section('title')
    Improove HR - Absences
@endsection

@section('content')
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">


                <p>AVAILABLE VACATIONS : {{$numberVacationsAvailable}}</p>

                <p>TOTAL : {{$vacations_total}}</p>


                </div>
            </div>
        </div>


    </body>

@endsection

