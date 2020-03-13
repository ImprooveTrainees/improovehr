@extends('layouts.template')

@section('title')
    Improove HR - Professional Info
@endsection

@section('content')
<div class="shadow p-1 bg-white cardbox1">
    <div class="box1">
    <img src="img/users/Admin.jpg" alt="img" id="profile2">
    <p>Professional Data</p>
    <hr>
<form class="form-group">

     @foreach ($profInfo as $row) {{-- Data from controller querys --}}

    <div class="form-group role">
        <label for="">Role:</label>
        @if($row->position == null)

            <p id="p1">Insert Role</p>
        @else
            <p id="p1">{{$row->position}}</p>
        @endif
    </div>

        <div class="form-group admissiondate">
            <label for="">Admission Date:</label>

            @if($row->start_date == null)
                <p id="p1">No contract uploaded</p>
            @else
                <p id="p1">{{$row->start_date}}</p>
            @endif
        </div>

        <div class="form-group typeofcontract">
            <label for="">Type of Contract:</label>
            @if($row->contracType == null)
            <p id="p1">No contract uploaded</p>
            @else
            <p id="p1">{{$row->contracType}}</p>
                @endif
        </div>

        <div class="form-group endofcontract">
            <label for="">End of Contract:</label>
            @if($row->end_date == null)
            <p id="p1">No contract uploaded</p>
            @else
            <p id="p1">{{$row->end_date}}</p>
            @endif
        </div>

        <div class="form-group companymobile">
            <label for="">Company Mobile:</label>
        @if($row->compPhone == null)
                <input type="number" class="form-control" id="companymobile2" placeholder="Insert Phone Number">
          @else
                <input type="number" class="form-control" id="companymobile2" value="{{$row->compPhone}}">
            @endif
        </div>

        <div class="form-group companyemail">
            <label for="">Company Email:</label>
            @if($row->compMail == null)
                <input type="email" class="form-control" id="companyemail2" placeholder="Insert e-mail">
            @else
                <input type="email" class="form-control" id="companyemail2" value="{{$row->compMail}}">
            @endif
        </div>

        <div class="form-group department">
            <label for="">Department:</label>
            @if($row->description == null)
            <p id="p1">No department</p>
            @else
            <p id="p1">{{$row->description}}</p>
            @endif
        </div>
         @foreach ($manager as $row) {{-- For Dep. Manager --}}

        <div class="form-group departmentmanager">
            <label for="">Department Manager:</label>
            @if($row->Manager == null)
            <p id="p1">No manager</p>
            @else
            <p id="p1">{{$row->Manager}}</p>
            @endif
        </div>
        @endforeach  {{--END For Dep. Manager --}}

        <div id="subtitle">
            <p>Documents</p>
            <hr><br>
            @foreach ($usersAttachments as $item)
                    {{$item->files}}--||--
            @endforeach
        </div>
        <br>
        <div id="attachments" >
            <form  method="POST">
                <div class="custom-file">
                    <input type="file" name="user_img" class="custom-file-input" id="customFile" accept="file_extension|pdf/*|image">
                    @csrf
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <br><br>
                <button type="submit" id="btnupload" class="form-group btn btn-outline-primary bprofile">Upload file</button>
            </form>
        </div>

         @endforeach {{--End of controller info --}}
  </form>
  <button type="submit" class="form-group btn btn-outline-primary bprofile">Save</button>
    </div>
</div>

@endsection
