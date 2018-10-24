<div class="text-muted assignees-block" style="margin-top: 10px">
    @if(count($issue->assignees))
        <span>@lang('projects.issue_assigned_to'):</span>
        @foreach($issue->assignees as $assignedUser)
            <span style="display: block">
                <a href="{{ route('user', ['user_name'=>$assignedUser->name]) }}">
                    <span>@</span>{{ $assignedUser->name }}
                </a>
                <a href="{{route('project.issue.detach_user', ['project'=>$project, 'issue'=>$issue, 'user'=>$assignedUser])}}">
                    <span class="glyphicon glyphicon-paste text-danger"></span>
                </a>
            </span>
        @endforeach
    @endif

    <span class="dropdown pull-right">
        <button class="btn btn-default btn-sm dropdown-toggle" style="border-radius: 2px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.09); padding: 2px 5px; margin-bottom: 7px" type="button" data-toggle="dropdown">
            @lang('projects.issue_attach_user')
            <span class="glyphicon glyphicon-paperclip"></span>
        </button>
        <ul class="dropdown-menu" style="min-width: unset">
            @if( $issue->assignees->contains(auth()->user()) )
                <a href="{{route('project.issue.detach_user', ['project'=>$project, 'issue'=>$issue, 'user'=>auth()->user()])}}" class="btn btn-default pull-right">
                    <span>@lang('projects.issue_deattach_myself')</span>
                    <img width="20px" src="{{ auth()->user()->imageLink() }}" alt="profile image">
                </a>
            @else
                <a href="{{route('project.issue.attach_user', ['project'=>$project, 'issue'=>$issue, 'user'=>auth()->user()])}}" class="btn btn-default pull-right">
                    <span>@lang('projects.issue_attach_myself')</span>
                    <img width="20px" src="{{ auth()->user()->imageLink() }}" alt="profile image">
                </a>
            @endif

            @can('delete', $issue)
                    @foreach($project->members as $member)
                        @if( $member->id !== auth()->user()->id && ! $issue->assignees->contains($member) )
                            <li>
                                <a href="{{route('project.issue.attach_user', ['project'=>$project, 'issue'=>$issue, 'user'=>$member])}}">
                                    <img width="20px" src="{{ $member->imageLink() }}" alt="profile image">
                                    <span>{{$member->name}}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
            @endcan
        </ul>
    </span><br>

</div>