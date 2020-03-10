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
    <div class="form-group username">
        <label for="">Role:</label>
      <input type="text" class="form-control" id="role" placeholder="">
    </div>

        <div class="form-group birthday">
            <label for="">Admission Date:</label>
          <input type="date" class="form-control" id="admissiondate" placeholder="">
        </div>

        <div class="form-group age">
            <label for="">Type of Contract:</label>
          <input type="text" class="form-control" id="typecontract" placeholder="">
        </div>

        <div class="form-group birthday">
            <label for="">End of Contract:</label>
          <input type="date" class="form-control" id="endofcontract" placeholder="">
        </div>

        <div class="form-group age">
            <label for="">Company Mobile:</label>
          <input type="number" class="form-control" id="companymobile" placeholder="">
        </div>

        <div class="form-group birthday">
            <label for="">Company Email:</label>
          <input type="email" class="form-control" id="companyemail" placeholder="">
        </div>

        <div class="form-group age">
            <label for="">Department:</label>
          <input type="text" class="form-control" id="department" placeholder="">
        </div>

        <div class="form-group birthday">
            <label for="">Department Manager:</label>
          <input type="text" class="form-control" id="depmanager" placeholder="">
        </div>


        <div id="subtitle">
            <p>Bank Data</p>
            <hr>
        </div>

        <div class="form-group zipcode">
            <label for="">IBAN:</label>
          <input type="text" class="form-control" id="nifnumber" placeholder="">
        </div>

        <div id="subtitle">
            <p>Documents</p>
            <hr>
        </div>


  </form>
  <button type="submit" class="form-group btn btn-outline-primary bprofile">Save</button>
    </div>
</div>

@endsection
