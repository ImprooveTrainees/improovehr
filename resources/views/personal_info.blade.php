@extends('layouts.template')

@section('title')
    Improove HR - Personal Info
@endsection

@section('sidebarpersonal')
active
@endsection

@section('opensidebar')
open
@endsection


@section('content')
<div class="shadow p-1 bg-white cardbox1">
    <div class="box1">
      @if($users->photo == null)
        <h5>Insert a profile image</h5>
        @else
        <img src="{{$users->photo}}" alt="img" id="profile">
      @endif
    
    <form id="file-upload-form" class="element" action="/saveProfileImage" method="post" accept-charset="utf-8" enctype="multipart/form-data">
      @csrf   
      <div class="shadow p-1 bg-white cardbox4">
            <i class="fa fa-camera" id="imagefile"></i>
              <input id="file-upload" type="file" name="fileUpload" accept="image/*" onchange="insertImage()">
              <img id="file-image" src="#" alt="" class="hidden">
        </div>
      </form>



<form class="form-group profileform" action="/editar">

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <p>Personal Data</p>
    <hr id="lineform">
    <div class="form-group username">
        <label for="">Name:</label>
        @if($users->name == null)
      <input type="text" name="name" class="form-control" placeholder="Insira o nome">
        @else
        <input type="text" name="name" class="form-control" placeholder="Insira o nome" value={{$users->name}}>
        @endif
    </div>

        <div class="form-group status">
            <label for="">Status:</label>
            <select class="form-control" name="status" id="exampleFormControlSelect1">
              @if($users->status == null)
                @foreach($statusArray as $status)
                  <option>{{$status}}</option>
                @endforeach
              @else
                  @foreach($statusArray as $status2)
                    @if($users->status == $status2)
                      <option selected="selected">{{$status2}}</option>
                      <?php continue; ?>
                    @endif
                     <option>{{$status2}}</option>
                  @endforeach
              @endif
            </select>
          </div>

          <div class="form-group academic">
            <label for="">Academic Qualifications:</label>
            <select class="form-control" name="academic" id="exampleFormControlSelect2">
              @if($users->academicQual == null)
                @foreach($statusAcademic as $acad)
                  <option>{{$acad}}</option>
                @endforeach
              @else
                  @foreach($statusAcademic as $acad2)
                    @if($users->academicQual == $status2)
                      <option selected="selected">{{$acad2}}</option>
                      <?php continue; ?>
                    @endif
                     <option>{{$acad2}}</option>
                  @endforeach
              @endif
              </select>
        </div>

        <div class="form-group birthday">
            <label for="">Birthday Date:</label>
             @if($users->birthDate == null)
            <input type="date" name="birthday" class="form-control" placeholder="Insert Birthday Date">
            @else
            <input type="date" name="birthday" class="form-control" value={{$users->birthDate}}>
            @endif
        </div>


        <div class="form-group mobile">
            <label for="">Mobile:</label>
            @if($users->phone == null)
           <input type="number" name="mobile" class="form-control" id="mobilenumber" placeholder="Insert phone number">
            @else
            <input type="number" name="mobile" placeholder="Insert phone number" class="form-control" value={{$users->phone}}>
            @endif
        </div>

        <div class="form-group emailprofile">
            <label for="">Email:</label>
            @if($users->email == null)
           <input type="email" name="email" class="form-control" id="emailprofile" placeholder="Insert email">
            @else
            <input type="email" name="email" class="form-control" placeholder="Insert email" value={{$users->email}}>
            @endif
        </div>

        <div class="form-group nif">
            <label for="">NIF:</label>
             @if($users->taxNumber == null)
           <input type="number" name="nif" class="form-control" id="nifnumber" placeholder="Insert NIF">
            @else
            <input type="number" name="nif" class="form-control" placeholder="Insert NIF" value={{$users->taxNumber}}>
            @endif
        </div>


        <div id="subtitle">
            <p>Address Data</p>
            <hr>
        </div>

        <div class="form-group address">
            <label for="">Address:</label>
            @if($users->address == null)
           <input type="text" name="address" class="form-control" placeholder="Insert Address">
            @else
            <input type="text" name="address" class="form-control" placeholder="Insert Address" value={{$users->address}}>
            @endif
        </div>

        <div class="form-group city">
            <label for="">City:</label>
            @if($users->city == null)
           <input type="text" name="city" class="form-control" placeholder="Insert City">
            @else
            <input type="text" name="city" class="form-control" placeholder="Insert City" value={{$users->city}}>
            @endif
        </div>

        <div class="form-group zipcode">
            <label for="">Zip-Code:</label>
            @if($users->zip_code == null)
           <input type="text" name="zip" class="form-control" id="nifnumber" placeholder="Insert zip-code">
            @else
            <input type="text" name="zip" class="form-control" placeholder="Insert zip-code" value={{$users->zip_code}}>
            @endif
        </div>

        <div id="subtitle">
            <p>SOS Contact</p>
            <hr>
        </div>

        <div class="form-group sosusername">
            <label for="">Name:</label>
             @if($users->sosName == null)
           <input type="text" name="sosName" class="form-control" placeholder="Insert SOS contact name">
            @else
            <input type="text" name="sosName" class="form-control" placeholder="Insert SOS contact name" value={{$users->sosName}}>
            @endif
        </div>

        <div class="form-group soscontact">
            <label for="">SOS Contact:</label>
            @if($users->sosContact == null)
            <input type="number" name="sosContact" class="form-control" id="mobilenumber" placeholder="Insert Number">
            @else
            <input type="text" name="sosContact" class="form-control" placeholder="Insert Number" value={{$users->sosContact}}>
            @endif
        </div>

        <div id="subtitle">
            <p>Bank Data</p>
            <hr>
        </div>

        <div class="form-group zipcode">
            <label for="">IBAN:</label>
             @if($users->iban == null)
            <input type="text" name="iban" class="form-control" id="iban" placeholder="Insert IBAN">
            @else
            <input type="text" name="iban" class="form-control" placeholder="Insert IBAN" value={{$users->iban}}>
            @endif
        </div>

        <div id="subtitle">
            <p>Social Network</p>
            <hr>
        </div>

        <div class="form-group linkedin">
            <label for="">LinkedIn:</label>
            @if($users->linkedIn == null)
            <input type="text" name="linkedIn" class="form-control" placeholder="Insert Link">
            @else
            <input type="text" name="linkedIn" class="form-control" placeholder="Insert Link" value={{$users->linkedIn}}>
            @endif
        </div>

  <button type="submit" class="form-group btn btn-outline-primary bprofile">Save</button>
  </form>
    </div>
</div>

@endsection

<script>
    //   function readURL(input, id) {
    //     id = id || '#file-image';
    //     if (input.files &amp;&amp; input.files[0]) {
    //         var reader = new FileReader();

    //         reader.onload = function (e) {
    //             $(id).attr('src', e.target.result);
    //         };

    //         reader.readAsDataURL(input.files[0]);
            
    //     }

       
    //  }

    function insertImage() {
      document.getElementById('file-upload-form').submit();
    }


</script>