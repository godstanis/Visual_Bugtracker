<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ url('/favicon.ico') }}">


    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>BugWall</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/addon-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('bootstrap-social/assets/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('bootstrap-social/bootstrap-social.css') }}" />
    @yield('head-styles')

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.2.0.min.js') }}"></script>
    <!-- <script src="{{ asset('js/jquery-ui.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
    
    @yield('head-scripts')
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        $(function() {
            $.ajaxSetup({
                headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>

</head>