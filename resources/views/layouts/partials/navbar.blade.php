
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
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                &nbsp;
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">@lang('auth.login')</a></li>
                    <li><a href="{{ route('register') }}">@lang('auth.register')</a></li>
                @else
                    <li>
                        <a href="{{ route('bugtracker.projects') }}">
                            <span class="glyphicon glyphicon-file"></span> @lang('projects.my_projects')
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">
                        
                            <img src="{{ Auth::user()->imageLink() }}" width="30px" height="30px">

                            <span>{{ Auth::user()->name }} <span class="caret"></span></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('user', ['user'=>Auth::user()]) }}"><span class="glyphicon glyphicon-user"></span> @lang('auth.my_profile')</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{route('user.settings')}}"><span class="glyphicon glyphicon-cog"></span> @lang('auth.settings')</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <span class="glyphicon glyphicon-log-out"></span> @lang('auth.logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            
                        </ul>
                    </li>
                @endif
                <!--
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle language-dropdown-toggle" data-toggle="dropdown">
                        <img width="18px" src="{{ asset('images/language_icons/'.App::getLocale().'.png') }}" alt="{{ Config::get('languages')[App::getLocale()] }}">
                    </a>
                    <ul class="dropdown-menu">
                        @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                <li>
                                    <a href="{{ route('lang.set', $lang) }}">
                                        <img width="18px" src="{{ asset('images/language_icons/'.$lang.'.png') }}" alt="{{ $language }}">
                                        {{ $language }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                -->
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
