
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container col-md-8 col-md-offset-2">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url('/images/logo-icon.svg') }}" onerror="{{ url('/images/logo-icon.png') }}" alt="BugWall">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (auth()->guest())
                    <li><a href="{{ route('login') }}">@lang('auth.login')</a></li>
                    <li><a href="{{ route('register') }}">@lang('auth.register')</a></li>
                @else
                    @include('layouts.partials.menu.projects-dropdown')
                    @include('layouts.partials.menu.auth-dropdown')
                @endif
            </ul>
        </div>
    </div>
</nav>

@if( session('message') )
<div class="alert alert-success alert-dismissable" style="position:fixed; right: 20px; bottom: 20px; z-index: 999">
    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
    {{ session('message') }}
</div>
@endif
