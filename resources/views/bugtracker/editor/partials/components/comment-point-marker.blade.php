<marker style="transform: translate({{$commentPoint->position_x}}px,{{$commentPoint->position_y}}px);" class="comment-point-marker">
                <span style="display:block">
                    {{$commentPoint->text}}
                </span>
    <span class="text-muted small">Created by {{$commentPoint->creator->name}}</span>
</marker>