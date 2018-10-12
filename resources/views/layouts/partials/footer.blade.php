<div class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <p class="navbar-text pull-left small">
            © 2016-{{date('Y')}} - Site Built By <a  href="https://github.com/stasgar" target="_blank">Stanislav Bogatov</a>

        </p>
        <a class="navbar-btn btn btn-sm btn-social btn-github" href="https://github.com/stasgar/Visual_Bugtracker" target="_blank">
            <span class="fa fa-github"></span> Check out on GitHub
        </a>


        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown pull-right">

            <a href="#" class="dropdown-toggle language-dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
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


        </ul>
    </div>
</div>