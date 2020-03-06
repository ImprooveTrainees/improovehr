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
        <label for="">Enterprise:</label>
      <input type="text" class="form-control" id="enterprise" placeholder="">
    </div>

        <div class="form-group birthday">
            <label for="">Admission Date:</label>
          <input type="date" class="form-control" id="admissiondate" placeholder="">
        </div>

        <div class="form-group age">
            <label for="">Department:</label>
          <input type="number" class="form-control" id="department" placeholder="">
        </div>

        <div class="form-group age">
            <label for="">Department Manager:</label>
          <input type="number" class="form-control" id="departmentmanager" placeholder="">
        </div>

        <div class="form-group mobile">
            <label for="">Company Mobile:</label>
          <input type="number" class="form-control" id="companymobile" placeholder="">
        </div>

        <div class="form-group emailprofile">
            <label for="">Company Email:</label>
          <input type="email" class="form-control" id="companyemail" placeholder="">
        </div>

        <div class="form-group nif">
            <label for="">Type of Contract:</label>
          <input type="number" class="form-control" id="typecontract" placeholder="">
        </div>

        <div id="subtitle">
            <p>Address Data</p>
            <hr>
        </div>

        <div class="form-group address">
            <label for="">Address:</label>
          <input type="text" class="form-control" placeholder="Insert Address">
        </div>

        <div class="form-group city">
            <label for="">City:</label>
          <input type="text" class="form-control" placeholder="Insert City">
        </div>

        <div class="form-group zipcode">
            <label for="">Zip-Code:</label>
          <input type="text" class="form-control" id="nifnumber" placeholder="Insert Zip-code">
        </div>

        <div id="subtitle">
            <p>SOS Contact</p>
            <hr>
        </div>

        <div class="form-group username">
            <label for="">Person Name:</label>
          <input type="text" class="form-control" placeholder="Insert Name">
        </div>

        <div class="form-group mobile">
            <label for="">SOS Contact:</label>
          <input type="number" class="form-control" id="mobilenumber" placeholder="Insert Number">
        </div>

        <div id="subtitle">
            <p>Bank Data</p>
            <hr>
        </div>

        <div class="form-group zipcode">
            <label for="">IBAN:</label>
          <input type="text" class="form-control" id="nifnumber" placeholder="Insert IBAN">
        </div>

        <div id="subtitle">
            <p>social Network</p>
            <hr>
        </div>

        <div class="form-group address">
            <label for="">Facebook:</label>
          <input type="text" class="form-control" id="nifnumber" placeholder="Insert Link">
        </div>

        <div class="form-group city">
            <label for="">LinkedIn:</label>
          <input type="text" class="form-control" placeholder="Insert Link">
        </div>

        <div class="form-group zipcode">
            <label for="">Instagram:</label>
          <input type="text" class="form-control" id="nifnumber" placeholder="Insert Link">
        </div>

  </form>
  <button type="submit" class="form-group btn btn-outline-primary bprofile">Save</button>
    </div>
</div>

@endsection
