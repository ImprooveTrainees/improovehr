@extends('layouts.template')

@section('title')
    Improove HR - Personal Info
@endsection

@section('content')
<div class="shadow p-1 bg-white cardbox1">
<form class="form-group">
    <div class="form-group username">
        <label for="">Username:</label>
      <input type="text" class="form-control" id="inputPassword2" placeholder="Name">
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
  </form>
</div>

@endsection
