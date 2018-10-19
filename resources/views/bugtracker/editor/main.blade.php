<!DOCTYPE html>
<html lang="en" style="touch-action:pan-down">

@include('bugtracker.editor.partials.head')

<body>
<div class="tabs-btns editor-controls">

<div id="editor-controls-buttons" class="collapse">

    <button id="browser-tab-btn" class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span> @lang('projects.viewer')</button>
    <button id="editor-tab-btn" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> @lang('projects.editor')</button>

<br>
<br>
    <button data-href="{{route('project.create_board', compact('project'))}}" data-token="{{csrf_token()}}" id="screenshotBoard" class="btn btn-success" style="display:none">
    <span class="glyphicon glyphicon-camera"></span>
    </button>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#create-board-modal"><span class="glyphicon glyphicon-arrow-up">
    </span> @lang('projects.upload-image')
    </button>
<br>
<br>
</div>

<button style="width:100%; min-width: 60px; height: 20px; padding: 0px" class="btn btn-default" data-toggle="collapse" data-target="#editor-controls-buttons"><span class="glyphicon glyphicon-chevron-down"></span></button>
</div>

<a href="{{ route('project.boards', compact('project')) }}" class="btn btn-success return-to-boards"><span class="glyphicon glyphicon-triangle-left"></span><span class="glyphicon glyphicon-blackboard"></span> @lang('editor.return_to_boards')</a>

@include('bugtracker.editor.partials.create-board-modal')

{!! view('bugtracker.project.partials.issue_create_modal', ['project'=>$project])->render() !!}


@if(!$boards->isEmpty())
<div id="editor-tab">
    @include('bugtracker.editor.partials.editor')
</div>
@endif

<div id="browser-tab" @if(!$boards->isEmpty()) hidden @endif>
    @include('bugtracker.editor.partials.viewer')
</div>

<div class="boards editor-controls">
    <div class="boards-toggle">
    <button class="btn btn-warning" data-toggle="collapse" data-target="#boards-block">
        <span class="glyphicon glyphicon-chevron-up"></span>
        <span>@lang('projects.boards')</span>
    </button>
    </div>
    <div>
        <div id="boards-block" class="collapse">
            @if($current_board)
                @foreach($boards as $board)
                    @include('bugtracker.editor.partials.board-box')
                @endforeach
            @endif
        </div>
    </div>
</div>

</body>

<script>
    /*
        Components initialization.
    */
    drawSVG.initElementById('svg-area');
    svgEditor.init('svg-work-area', 'svg-area', 'bg-element');
</script>

<script>

    let editor_page_data = {
        board_id: "{{$current_board->id}}",
        project_id: "{{$project->id}}",
        delete_path_link:"{{route('board.delete_path', ['project'=>$project, 'board'=>$current_board]) }}",
        create_path_link: "{{route('board.create_path', ['project'=>$project, 'board'=>$current_board])}}",
        board_paths_link: "{{route('board.paths', ['project'=>$project, 'board'=>$current_board])}}",
        board_comment_points: {
            index: "{{route('comment_points.index', ['project'=>$project, 'board'=>$current_board])}}",
            form: "{{route('comment_points.create', ['project'=>$project, 'board'=>$current_board])}}"
        },

    };

    @if($current_board !== null)
        let image = document.getElementById('bg-element-image').src;
        svgEditor.initImage(image);

        $.getJSON(editor_page_data.board_paths_link, function(data){
            dataConstructor.drawElementsFromJSON(drawSVG, data);
        });
    @endif

</script>

<script src="{{asset('editor/js/src/ui.js')}}"></script>

<script src="{{asset('editor/js/src/editorControlsModule.js')}}"></script>
<script src="{{asset('editor/js/src/drawModule.js')}}"></script>
<script src="{{asset('editor/js/src/editor.js')}}"></script>

<script src="{{asset('editor/js/src/pusher.js')}}"></script>
<script src="{{asset('editor/js/src/editorDataManager.js')}}"></script>

<script src="{{asset('editor/js/src/commentPoint.js')}}"></script>

</html>
