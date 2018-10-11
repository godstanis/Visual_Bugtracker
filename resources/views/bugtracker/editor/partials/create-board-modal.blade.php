<!-- Modal -->
<div class="modal fade" id="create-board-modal" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">@lang('custom.choose_image_file')</h4>
                
            </div>

            <form action="{{route('project.create_board', compact("project"))}}" method="POST" class="create-board-form" enctype="multipart/form-data">
            <div class="modal-body">
                
                    <input name="board_image" type="file" class="form-control" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
            </div>
            <div class="modal-footer">
                
                <button class="btn btn-success">@lang('custom.save')</button>
            </div>
            
            </form>
        </div>
    </div>
</div>
