<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('layouts.partials.head')
<body>
    <div id="app">
        @include('layouts.partials.navbar')

        <div class="content container fill col-md-10 col-md-offset-1 bugtracker-content-container">
            @yield('content')
        </div>

    </div>

    @include('layouts.partials.footer');

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}"></script>-->
</body>
</html>