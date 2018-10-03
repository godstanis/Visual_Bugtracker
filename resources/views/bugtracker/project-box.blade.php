<div class="project-box project-box-view">
    <div class="project-box-content">
        <div class="project-box-controls pull-right btn-group">
            <!--<button class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>-->
            @can('delete', $project)
            <form class="delete-project-form" action="{{route('bugtracker.delete_project', ['project'=>$project->id])}}" method="POST">
                <button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
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
            <span><a href="{{ route('user', ['user_name'=>$project->creator->name]) }}"><span>@</span>{{$project->creator->name}}</a></span>
            <img width="20px" src="{{ $project->creator->imageLink() }}" alt="">
        </span>
    </div>
    <div class="project-box-open-btn">
        <a class="btn btn-success" href="{{ route('bugtracker.project', ['project_id'=>$project->id]) }}"><span class="glyphicon glyphicon-folder-open"></span>&nbsp; @lang('projects.open')</a>
    </div>
</div>
