<div id="footer" class="footer navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <p class="navbar-text pull-left small">
            <span>
                © 2016-{{date('Y')}} - Site Built By <a  href="https://github.com/stasgar" target="_blank">Stanislav Bogatov &nbsp;</a>
            </span>
        </p>

        <a class="navbar-btn btn btn-sm btn-social btn-github" href="https://github.com/stasgar/Visual_Bugtracker" target="_blank">
            <span class="fa fa-github"></span><span class="btn-github-text">Check out on GitHub</span>
        </a>

        <div class="dropdown pull-right navbar-btn">
            <button class="dropdown-toggle language-dropdown-toggle btn btn-default" data-toggle="dropdown">
                <span class="caret"></span>
                <img width="18px" src="{{ asset('images/language_icons/'.App::getLocale().'.png') }}" alt="{{ Config::get('languages')[App::getLocale()] }}">
            </button>
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
        </div>
    </div>
</div>