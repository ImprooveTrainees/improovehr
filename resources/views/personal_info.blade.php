@extends('layouts.template')

@section('title')
    Improove HR - Personal Info
@endsection

@section('content')
<div class="shadow p-1 bg-white cardbox1">
    <div class="box1">
    <img src="img/man.png" alt="img" id="profile">
    <p>Personal Data</p>
    <hr>
<form class="form-group">
    <div class="form-group username">
        <label for="">Name:</label>
      <input type="text" class="form-control" placeholder="Name">
    </div>

        <div class="form-group status">
            <label for="">Status:</label>
            <select class="form-control" id="exampleFormControlSelect1">
              <option>1</option>
              <option>2</option>
              <option>3</option>
              <option>4</option>
              <option>5</option>
            </select>
          </div>

          <div class="form-group academic">
            <label for="">Academic Qualifications:</label>
            <select class="form-control" id="exampleFormControlSelect2">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
        </div>

        <div class="form-group birthday">
            <label for="">Birthday Date:</label>
          <input type="date" class="form-control" placeholder="Name">
        </div>

        <div class="form-group age">
            <label for="">Age:</label>
          <input type="number" class="form-control" id="agenumber" placeholder="Insert Age">
        </div>

        <div class="form-group mobile">
            <label for="">Mobile:</label>
          <input type="number" class="form-control" id="mobilenumber" placeholder="Insert Mobile">
        </div>

        <div class="form-group emailprofile">
            <label for="">Email:</label>
          <input type="email" class="form-control" id="emailprofile" placeholder="Insert Email">
        </div>

        <div class="form-group nif">
            <label for="">NIF:</label>
          <input type="number" class="form-control" id="nifnumber" placeholder="Insert NIF">
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
