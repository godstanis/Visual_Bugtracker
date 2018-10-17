<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@section('head-styles')
    <link rel="stylesheet" href="{{asset("css/home-page.css")}}">
@endsection

@include('layouts.partials.head')
<body>
<div id="app">
    @include('layouts.partials.navbar')
    <div class="content">
        <div class="container">
            <h1 class="text-center">@lang('Welcome to the site')</h1>

            <hr>
            @if (Auth::guest())
                <div>
                    <a class="btn btn-success btn-lg col-md-5 col-xs-12" href="{{ route('login') }}">@lang('auth.login')</a>
                    <div class="visible-xs">
                        <br><br><br>
                    </div>
                    <a class="btn btn-success btn-lg col-md-5 col-md-offset-2 col-xs-12" href="{{ route('register') }}">@lang('auth.register')</a>
                </div>

            @else

                <div class="control-group">
                    <a class="btn btn-success btn-lg col-md-2 col-md-offset-5 col-xs-12" href="{{ route('bugtracker.projects') }}">@lang('projects.my_projects')</a>
                </div>

            @endif
        </div>
    </div>
</div>
@include('layouts.partials.footer')
</body>
</html>
