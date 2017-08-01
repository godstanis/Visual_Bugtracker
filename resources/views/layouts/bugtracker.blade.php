<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('layouts.partials.head')
<body>
    <div id="app">
        @include('layouts.partials.navbar')

        <div class="content container col-md-12 bugtracker-content-container">
            @yield('content')
        </div>

    </div>

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}"></script>-->
</body>
</html>