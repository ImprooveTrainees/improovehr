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
<a href="/newEmployee"><button>Register New Employee</button></a>

    <table>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Company</th>
            <th>Role</th>
            <th>Department</th>
            <th>Time</th>
            <th>Staff Manager</th>
        </tr>


       <?php echo $msg ?>   
     


    </table>
<style>
.sliderResize {
    height: 50px;
    width: 60px;
}


</style>

</body>
</html>
