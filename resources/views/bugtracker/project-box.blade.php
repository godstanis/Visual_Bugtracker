<div class="project-box project-box-view">
    <div class="project-box-content">
        <div class="project-box-controls pull-right btn-group">
            @can('delete', $project)
                <div>
                    <a style="margin-right: -4px;" href="{{route('project.settings', compact('project'))}}" title="Edit project" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></a>
                    <form style="display:inline-block; margin:0" class="delete-project-form" action="{{route('bugtracker.delete_project', compact("project"))}}" method="POST">
                        <button class="btn btn-danger btn-sm" title="Delete project"><span class="glyphicon glyphicon-trash"></span></button>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>
                </div>
            @endcan
        </div>
        <h4 class="project-title">{{$project->name}}</h4>
        
        <div class="project-box-img">

        <img src="{{$project->thumbnailUrl()}}" alt="Project image">

        </div>

        <div class="project-box-credentials">
            <p class="project-description text-muted">{{$project->description}}</p>
        </div>

        <span class="pull-right project-box-creator">
            <span class="text-muted"><em><small>@lang('projects.created_by')</small></em></span>
            <span><a href="{{ route('user', ['user_name'=>$project->creator]) }}"><span>@</span>{{$project->creator->name}}</a></span>
            <img width="20px" src="{{ $project->creator->imageLink() }}" alt="">
        </span>
    </div>
    <div class="project-info">
        <span class="small text-muted" title="Project boards count" >
            {{count($project->boards)}}
            <span class="glyphicon glyphicon-blackboard"></span>
        </span>
        &nbsp;
        <span class="small text-muted" title="Project issues count">
            {{count($project->issues)}}
            <span class="glyphicon glyphicon-remove-circle"></span>
        </span>
    </div>
    <div class="project-box-open-btn">
        <a class="btn btn-success" href="{{ route('bugtracker.project', compact("project")) }}"><span class="glyphicon glyphicon-folder-open"></span>&nbsp; @lang('projects.open')</a>
    </div>
</div>
