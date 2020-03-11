<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<img src="" alt="">
    <div id="enterprisedata">
        <hr>
        <h4>EnterPrise data</h4><br>
        {{-- {{$profInfo}}<br> --}}

        @foreach ($profInfo as $row)

        <label for="role"><b>Role:--</b>{{$row->position}}</label><br>
        <label for="role"><b>Department:--</b>{{$row->description}}</label><br>
        <label for="role"><b>Type of Contract:--</b>{{$row->contracType}}</label><br>
        <label for="role"><b>Admission Date:--</b>{{$row->start_date}}</label><br>
        <label for="role"><b>End Date of Contract:--</b>{{$row->end_date}}</label><br>

        @endforeach

    Documents<br><br>
    <b>User Attachments:</b> <span>
        @foreach ($usersAttachments as $item)
        {{$item->files}}--||--
        @endforeach
        {{-- {{$usersAttachments}} --}}
    <hr>
    </div>

    <div id="editProfile">
        <form  method="POST" >
            <input type="file" name="user_img" accept="file_extension|pdf/*|image">
            @csrf
            <br><br>
            <button type="submit">Upload img</button>

        </form>

    </div>

</body>
</html>
