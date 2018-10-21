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

    @can('delete', $issue)
        <span class="dropdown pull-right">
            <button class="btn btn-default btn-sm dropdown-toggle" style="border-radius: 2px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.09); padding: 2px 5px;" type="button" data-toggle="dropdown">
                @lang('projects.issue_assign_user')
                <span class="glyphicon glyphicon-paperclip"></span>
            </button>
            <ul class="dropdown-menu" style="min-width: unset">
                @foreach($project->members as $member)
                    <li>
                        <a href="{{route('project.issue.attach_user', ['project'=>$project, 'issue'=>$issue, 'user'=>$member])}}">
                            <img width="20px" src="{{ $member->imageLink() }}" alt="profile image">
                            <span>{{$member->name}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </span>
        <br>
    @endcan
</div>