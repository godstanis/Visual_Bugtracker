<li class="dropdown">
    <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">
        <img src="{{ auth()->user()->imageLink() }}" width="20px" height="20px">
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a class="no-underline" href="{{ route('user', ['user'=>auth()->user()]) }}">@lang('auth.signed_as') <b>{{ auth()->user()->name }}</b></a>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <a href="{{ route('user', ['user'=>auth()->user()]) }}"> @lang('auth.my_profile')</a>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <a href="{{route('user.settings')}}"> @lang('auth.settings')</a>
        </li>
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                 @lang('auth.logout')
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>

    </ul>
</li>