<div id="svg-editor-area">
    <div id="svg-work-area" style="transform: scale(0.5)">
        <div id="svg-image-couple">
            <div id="bg-element" style="border: 2px solid #c5c5c5;">
                <img id="bg-element-image" src="{{ $current_board->sourceImageUrl() }}" alt="Board source image">
            </div>
        </div>
        <div id="markers-container-minimized">
            @foreach($commentPoints as $commentPoint)
                <marker style="transform: translate({{$commentPoint->position_x}}px,{{$commentPoint->position_y}}px);" class="comment-point-marker">
                <span style="display:block">
                    {{$commentPoint->text}}
                </span>
                    <span class="text-muted small">Created by {{$commentPoint->creator->name}}</span>
                </marker>
            @endforeach
        </div>
    </div>
</div>