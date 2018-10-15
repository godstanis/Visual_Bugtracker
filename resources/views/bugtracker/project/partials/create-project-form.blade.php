<form action="{{ route('bugtracker.create_project') }}" method="post" class="create-project-form" enctype="multipart/form-data">
    <div class="project-box-content">
        <div class="add-project-content" tabindex="1"><span>+</span></div>
        <div class="create-form-input-block">
            <input name="name" class="project-title-input form-control" type="text" placeholder="@lang('projects.name_placeholder')" required>
            <div class="help-block project_name"></div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="project-box-image-block" style="display:inline-block;">
            <div class="project-box-img">
                <img class="image-update" src="{{ asset('images\default_project_thumb.jpg') }}" alt="">
            </div>
            <div class="image-input-block">
                <input name="thumbnail_img" type="file" id="image-input" >
                <label for="image-input"><span class="glyphicon glyphicon-picture"></span> @lang('custom.choose_image_file')</label>
            </div>
        </div>
        <div class="project-box-credentials">
            <textarea name="description" class="project-description-textarea form-control" type="text" placeholder="@lang('projects.description_placeholder')" required></textarea>
        </div>
        <div class="help-block project_description"></div>
        <span class="pull-right project-box-creator">
            <span class="text-muted"><em><small>@lang('projects.creator_is')</small></em></span>
            <span class="text-muted">{{ Auth::user()->name }}</span>
            <img width="20px" src="{{ Auth::user()->imageLink() }}" alt="profile image">
        </span>
    </div>
    <div class="project-box-open-btn">
        <button class="btn btn-success project-create-btn" type="submit" title="Create new project"><span class="glyphicon glyphicon-paperclip"></span> @lang('projects.create')</button>
    </div>
</form>