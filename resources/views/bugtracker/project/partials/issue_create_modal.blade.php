<!-- Modal -->
<div class="modal fade" id="create-issue-modal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@lang('projects.issue_create')</h4>
        </div>

        <form action="{{ route('project.issue.create', compact("project")) }}" method="POST" class="create-issue-form">
        <div class="modal-body">
            
                <input class="form-control" type="text" name="title" placeholder="@lang('projects.issue_title')">
                <div class="help-block title"></div>
                <textarea class="form-control" name="description" cols="30" rows="3" placeholder="@lang('projects.issue_description')"></textarea>
                <div class="help-block description"></div>
                <select class="form-control" name="type_id" id="">
                    <option hidden selected>@lang('projects.issue_type')</option>
                    <option value="1">Bug</option>
                    <option value="2">Task</option>
                </select>
                <div class="help-block type_id"></div>
                <select class="form-control" name="priority_id" id="">
                    <option hidden selected>@lang('projects.issue_priority')</option>
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
                </select>
                <div class="help-block priority_id"></div>
                <select class="form-control" name="assigned_to_user_id" id="">
                    <option hidden selected>@lang('projects.issue_assigned_to')</option>
                    @foreach($project->team()->get() as $member)
                        <option value="{{ $member->user->id }}">{{ $member->user->name }}</option>
                    @endforeach
                </select>
                <div class="help-block assigned_to_user_name"></div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
        </div>
        <div class="modal-footer">
            
            <button class="btn btn-success">@lang('custom.save')</button>
        </div>
        </div>
        </form>
    </div>
</div>
