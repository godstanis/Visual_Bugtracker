<marker id="marker_id_{{$commentPoint->id}}" style="transform: translate({{$commentPoint->position_x}}px,{{$commentPoint->position_y}}px);" class="comment-point-marker">
    <a href="{{route('comment_points.destroy', ['project'=>$project, 'board'=>$current_board, 'comment_point'=>$commentPoint])}}" class="btn btn-danger btn-xs pull-right delete-marker-btn">
        <span class="glyphicon glyphicon-trash"></span>
    </a>
    <span style="display:block">
        {{$commentPoint->text}}
    </span>
    @if(isset($commentPoint->issue))
        <span class="text-muted"  style="display:block">
            <a class="title-link" href="{{ route('project.issue.discussion', ['issue'=>$commentPoint->issue, 'project'=>$project]) }}">
                <span>#{{$commentPoint->issue->id}} <b>{{$commentPoint->issue->title}}</b></span>
            </a>
        </span>
    @endif
    <span class="text-muted small">Created by {{$commentPoint->creator->name}}</span>
</marker>