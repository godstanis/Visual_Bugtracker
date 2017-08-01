<div class="board-box {{$board->id == $current_board->id ? 'active-board' : 'text'}}">
    <div class="board-box-content">
        <div class="board-box-controls pull-right btn-group">
            <!--<button class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span></button>-->

            <form class="delete-board-form" action="{{route('project.delete_board', ['board'=>$board, 'project'=>$project])}}" method="POST">
                <button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
                {{csrf_field()}}
            </form>

        </div>
        <h4 class="board-title board-box-title">{{ $board->name }}</h4>
        <div class="board-box-img">
            <img src="{{config('images.amazon_base_link').config('images.boards_images_dir').'/'.$board->thumb_image}}" alt="">
        </div>
        <div class="board-box-credentials">
            <span class="pull-right board-box-creator">
                <span class="text-muted"><em><small>@lang('projects.board_created_by')</small></em></span>
                <span><a href="{{route('user', ['user'=>$board->creator])}}"><span>@</span>{{ $board->creator->name }}</a></span>
                <img width="20px" src="https://s3.eu-central-1.amazonaws.com/bugwall.ru/user_profile_images/{{ $board->creator->profile_image }}" alt="profile image">
            </span>
        </div>
    
    </div>
    <div class="board-box-open-btn">
        <a class="btn btn-success" href="{{route('project.editor', ['project'=>$project, 'board'=>$board])}}">@lang('projects.open')</a>
    </div>
</div>