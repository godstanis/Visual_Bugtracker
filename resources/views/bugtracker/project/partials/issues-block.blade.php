<div class="issue-data-block">
<table class="table table-inverse table-bordered table-hover table-responsive issues-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>@lang('projects.issue_title')</th>
            <th>@lang('projects.issue_description')</th>
            <th>@lang('projects.issue_type')</th>
            <th>@lang('projects.issue_priority')</th>
            <th>@lang('projects.issue_creator')</th>
            <th>@lang('projects.issue_assigned_to')</th>
            <th>@lang('projects.issue_created_at')</th>
            <th>@lang('projects.issue_updated_at')</th>
            <th>@lang('projects.issue_controls')</th>
        </tr>
    </thead>
    <tbody>
    @foreach($issues as $issue)

    <tr class="{{$issue->closed ? 'issue-closed-row':''}}">
        <td><b>{{ $issue->id }}</b></td>
        <td>{{ $issue->title }}</td>
        <td><div style="display:inline-block;
    width:100px;
    white-space: nowrap;
    overflow:hidden !important;
    text-overflow: ellipsis;">{{ $issue->description }}</div></td>
        <td><div class="issue-badge {{ $issue->type->title }}-type">{{ $issue->type->title }}</div></td>
        <td><div class="issue-badge {{ $issue->priority->title }}-priority">{{ $issue->priority->title }}</div></td>
        <td>
            <a href="{{ route('user', ['user_name'=>$issue->creator->name]) }}">
                <span>@</span>{{ $issue->creator->name }}
                <img class="user-profile-image" src="https://s3.eu-central-1.amazonaws.com/bugwall.ru/user_profile_images/{{ $issue->creator->profile_image }}" alt="" width="20px">
            </a>
        </td>
        <td>
            <a href="{{ route('user', ['user_name'=>$issue->assignedUser->name]) }}">
                <span>@</span>{{ $issue->assignedUser->name }}
                <img class="user-profile-image" src="https://s3.eu-central-1.amazonaws.com/bugwall.ru/user_profile_images/{{ $issue->assignedUser->profile_image }}" alt="" width="20px"></a>
            </a>
        </td>
        <td>{{ date('m-d-Y, h:s', strtotime($issue->created_at)) }}</td>
        <td>{{ $issue->updated_at->diffForHumans() }}</td>
        <td class=" text-center">
            <span class="btn-group issue-control-block">
            
                <div class="btn-group">
                  <a href="{{ route('project.issue.discussion', ['issue'=>$issue->id, 'project'=>$project->id]) }}" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span> Open</a>
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu pull-right">
                    <li>
                        @can('update', $issue)
                        <a href="#"><span class="glyphicon glyphicon-pencil"></span> Update</a>
                        @endcan
                    </li>
                    <li>
                        @can('delete', $issue)
                        <a href="{{ route('project.issue.delete', ['issue'=>$issue->id, 'project'=>$issue->project->id]) }}" class="delete-issue-btn" data-token="{{csrf_token()}}" ><span class="glyphicon glyphicon-trash"></span> Delete</a>
                        @endcan
                    </li>

                  </ul>
                </div>
            </span>
        </td>

    </tr>
    @endforeach
    </tbody>
</table>

<div class="pagination">
    {{ $issues->links() }}
</div>

</div>

<script>

        $( document ).ready(function(){
            $(function() {
                $('body').on('click', '.pagination a', function(e) {
                    e.preventDefault();

                    var url = $(this).attr('href');  
                    getIssues(url);
                    window.history.pushState("", "", url);
                });

                function getIssues(url) {
                    $.ajax({
                        url : url  
                    }).done(function (data) {
                        $('.issue-data-block').html(data);
                    }).fail(function () {
                        alert ('Issues could not be loaded.');
                    });
                }
            });
        });

</script>
