@extends('layouts.template')

@section('title')
    Improove HR Tool
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Varios Offices</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="div-row">
                        <div class="col-md-12">
                            <h4>Offices</h4>
                            @foreach ($offices as $row)
                                 {{$row->id}}
                                 {{$row->description}}
                                 {{$row->adress}}
                                 {{$row->mail}}
                                 {{$row->contact}}
                                 {{$row->country}}
                                 <br>
                            @endforeach
                            <br><h4>Departments</h4>
                            @foreach ($departments as $row)
                                 {{$row->id}}
                                 {{$row->description}}
                                 <br>
                            @endforeach
                             <br><h4>User - Department</h4>
                            {{-- @foreach ($userdepartments as $row)
                                 {{$row->id}}
                                 {{$row->idDepartment}}
                                 {{$row->idUser}}
                                 <br>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
