<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        <span>@lang('projects.my_projects')</span>
        <span class="caret"></span>
    </a>

    <ul class="dropdown-menu" role="menu">
        @foreach(auth()->user()->projects as $project)
            <li>
                <a href="{{ route('bugtracker.project', ['project'=>$project]) }}"><span class="glyphicon glyphicon-file"></span>
                    <span>{{$project->name}}</span>
                </a>
            </li>
        @endforeach
        <li role="separator" class="divider"></li>
        <li>
            <a href="{{route('bugtracker.projects')}}"><span class="glyphicon glyphicon glyphicon-plus"></span> @lang('projects.create')</a>
        </li>

    </ul>
</li>