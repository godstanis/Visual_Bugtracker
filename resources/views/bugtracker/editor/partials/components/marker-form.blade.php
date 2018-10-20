<form method="post" action="{{route('comment_points.index', ['project'=>$project, 'board'=>$current_board])}}" id="create-marker-form">
    <button type="button" class="btn btn-danger btn-xs pull-right close-marker-btn">
        <span class="glyphicon glyphicon-remove"></span>
    </button>
    <div class="input-group">
        <input type="text" name="text" class="form-control" placeholder="@lang('editor.comment_text')">
        <input type="number" name="position_x" value="0" hidden="">
        <input type="number" name="position_y" value="0" hidden="">
        <span class="input-group-btn"><input type="submit" value="Ok" class="btn btn-success"></span>
    </div>
    <div class="help-block priority_id"></div>
    <select class="form-control" name="issue_id" id="">
        <option selected value="null">@lang('projects.issue_without')</option>
        @foreach($project->issues as $issue)
            <option value="{{ $issue->id }}" title="{{ $issue->description }}">
                <span class="text-muted">
                    #{{ $issue->id }}
                </span>{{ $issue->title }}</option>
        @endforeach
    </select>
</form>