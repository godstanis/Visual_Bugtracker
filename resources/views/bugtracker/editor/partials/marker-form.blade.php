<form method="post" action="{{route('comment_points.index', ['project'=>$project, 'board'=>$current_board])}}" id="create-marker-form">
    <button type="button" class="btn btn-danger btn-xs pull-right close-marker-btn">
        <span class="glyphicon glyphicon-remove"></span>
    </button>
    <div class="input-group">
        <input type="text" name="text" class="form-control" placeholder="Comment title">
        <input type="number" name="position_x" value="0" hidden="">
        <input type="number" name="position_y" value="0" hidden="">
        <span class="input-group-btn"><input type="submit" value="Ok" class="btn btn-success"></span>
    </div>
    <input type="checkbox" name="add_task" value="add_task">Not working secret feature
</form>