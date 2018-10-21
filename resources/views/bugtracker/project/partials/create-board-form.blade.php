<form action="{{route('project.create_board', compact("project"))}}" method="POST" class="create-board-form" enctype="multipart/form-data">
    <div class="board-box-content">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="text" name="name" class="form-control" placeholder="Board name">
        <div class="help-block name"></div>
        <div class="board-box-image-block">
            <div class="board-box-img">
                <img class="image-update" alt="">
            </div>
            <div class="image-input-block">
                <input type="file" name="image"  id="image-input" >
                <label for="image-input"><span class="glyphicon glyphicon-picture"></span> @lang('custom.choose_image_file')</label>
            </div>
        </div>
    </div>
    <div class="board-box-open-btn">
        <button class="btn btn-success board-create-btn" type="submit" title="Create new board"><span class="glyphicon glyphicon-paperclip"></span> @lang('projects.create')</button>
    </div>
</form>
