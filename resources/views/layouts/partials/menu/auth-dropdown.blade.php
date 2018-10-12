<li class="dropdown">
    <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">

        <img src="{{ auth()->user()->imageLink() }}" width="30px" height="30px">

        <span>{{ auth()->user()->name }} <span class="caret"></span></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{{ route('user', ['user'=>auth()->user()]) }}"><span class="glyphicon glyphicon-user"></span> @lang('auth.my_profile')</a>
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