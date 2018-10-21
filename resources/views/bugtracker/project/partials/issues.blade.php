<div class="issue-data-block">
    @foreach($issues as $issue)
        <div class="issue-row">
            <div>
                <div>
                    <a class="title-link" href="{{ route('project.issue.discussion', ['issue'=>$issue, 'project'=>$project]) }}">
                        <span><b>{{ $issue->title }}</b></span>
                    </a>
                    @can('delete', $issue)
                        <a class="delete-link" href="{{ route('project.issue.delete', ['issue'=>$issue, 'project'=>$issue->project]) }}">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    @endcan
                    @if(count($issue->discussion)>0)
                        <span class="text-muted label label-default">
                            {{count($issue->discussion)}} &nbsp;
                            <span class="glyphicon glyphicon-comment"></span>
                        </span>
                    @endif
                    @if( isset($issue->commentPoints) )
                        <a href="{{ route('project.issue.discussion', ['issue'=>$issue, 'project'=>$project]) }}">
                        @foreach($issue->commentPoints as $commentPoint)
                            <span class="text-muted small">
                                <b>#<span>{{$commentPoint->id}}</span></b>
                            </span>
                        @endforeach
                        </a>
                    @endif
                    <span class="small pull-right">
                        @lang('projects.issue_type'):
                        <span class="issue-badge {{ $issue->type->title }}-type">{{ $issue->type->title }}</span>
                        @lang('projects.issue_priority'):
                        <span class="issue-badge {{ $issue->priority->title }}-priority">{{ $issue->priority->title }}</span>
                    </span>
                </div>

                <div class="small text-muted pull-right">
                    @if(count($issue->assignees))
                        <span>@lang('projects.issue_assigned_to')</span>
                        @foreach($issue->assignees as $assignedUser)
                            {{ $loop->first ? '' : ', ' }}
                            <a href="{{ route('user', ['user_name'=>$assignedUser->name]) }}">
                                <span>@</span>{{ $assignedUser->name }}
                            </a>
                        @endforeach
                    @endif
                </div>

                <div class="small text-muted">
                    <span class="">#{{ $issue->id }}</span>

                    @lang('projects.issue_created_when', ['when'=>$issue->created_at])
                    <a href="{{ route('user', ['user_name'=>$issue->creator->name]) }}">
                        <span>@</span>{{ $issue->creator->name }}
                    </a>
                </div>
            </div>

        </div>
@endforeach



</div>

<div class="pagination">
    {{ $issues->links() }}
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
