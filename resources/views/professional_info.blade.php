@extends('layouts.template')

@section('title')
    Improove HR - Professional Info
@endsection

@section('content')
<div class="shadow p-1 bg-white cardbox1">
    <div class="box1">
    <img src="img/man.png" alt="img" id="profile">
    <p>Professional Data</p>
    <hr>
<form class="form-group">

     @foreach ($profInfo as $row) {{-- Data from controller querys --}}

    <div class="form-group username">
        <label for="">Role:</label>
        @if($row->position == null)
            <input type="text" class="form-control" id="role" placeholder="Insert Role">
        @else
            <input type="text" class="form-control" id="role" placeholder="{{$row->position}}">
        @endif
    </div>

        <div class="form-group birthday">
            <label for="">Admission Date:</label>
            @if($row->start_date == null)
                <input type="text" class="form-control" id="admissiondate" placeholder="No contract uploaded">
            @else
                <input type="text" class="form-control" id="admissiondate" placeholder="{{$row->start_date}}">
            @endif
        </div>

        <div class="form-group age">
            <label for="">Type of Contract:</label>
            @if($row->contracType == null)
                <input type="text" class="form-control" id="typecontract" placeholder="No contract uploaded">
            @else
                <input type="text" class="form-control" id="typecontract" placeholder="{{$row->contracType}}">
                @endif
        </div>

        <div class="form-group birthday">
            <label for="">End of Contract:</label>
            @if($row->end_date == null)
                <input type="text" class="form-control" id="endofcontract" placeholder="No contract uploaded">
            @else
                <input type="text" class="form-control" id="endofcontract" placeholder="{{$row->end_date}}">
            @endif
        </div>

        <div class="form-group age">
            <label for="">Company Mobile:</label>
        @if($row->compPhone == null)
                <input type="number" class="form-control" id="companymobile" placeholder="Insert Phone Number">
          @else
                <input type="number" class="form-control" id="companymobile" value="{{$row->compPhone}}">
            @endif
        </div>

        <div class="form-group birthday">
            <label for="">Company Email:</label>
            @if($row->compMail == null)
                <input type="email" class="form-control" id="companyemail" placeholder="Insert e-mail">
            @else
                <input type="email" class="form-control" id="companyemail" value="{{$row->compMail}}">
            @endif
        </div>

        <div class="form-group age">
            <label for="">Department:</label>
            @if($row->description == null)
                <input type="text" class="form-control" id="department" placeholder="No department">
            @else
                <input type="text" class="form-control" id="department" placeholder="{{$row->description}}">
            @endif
        </div>
         @foreach ($manager as $row) {{-- For Dep. Manager --}}

        <div class="form-group birthday">
            <label for="">Department Manager:</label>
            @if($row->Manager == null)
                <input type="text" class="form-control" id="depmanager" placeholder="No Manager">
            @else
                <input type="text" class="form-control" id="depmanager" placeholder="{{$row->Manager}}">
            @endif
        </div>
        @endforeach  {{--END For Dep. Manager --}}

        <div id="subtitle">
            <p>Bank Data</p>
            <hr>
        </div>

        <div class="form-group zipcode">
            <label for="">IBAN:</label>
          <input type="text" class="form-control" id="nifnumber" placeholder="personal info">
        </div>

        <div id="subtitle">
            <p>Documents</p>
            <hr>
            @foreach ($usersAttachments as $item)
                    {{$item->files}}--||--
            @endforeach
        </div>
        <div id="attachments">
            <form  method="POST" >
                <input type="file" name="user_img" accept="file_extension|pdf/*|image">
                @csrf
                <br><br>
                <button type="submit">Upload img</button>

            </form>

        </div>

         @endforeach {{--End of controller info --}}
  </form>
  <button type="submit" class="form-group btn btn-outline-primary bprofile">Save</button>
    </div>
</div>

@endsection
