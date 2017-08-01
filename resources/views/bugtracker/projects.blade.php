@extends('layouts.bugtracker')

@section('head-styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/projects.css') }}" />
@endsection

@section('head-scripts')
<script src="{{ asset('js/bugtracker/projects.js') }}"></script>
<script src="{{ asset('js/image-upload-input.js') }}"></script>
@endsection

@section('content')
    
    <h1><span class="glyphicon glyphicon-file"></span> @lang('projects.my_projects')</h1>
    <div class="projects-container">

    @if( ! empty($projects))
        @foreach($projects as $project)

                {!! View::make('bugtracker.project-box', ['project' => $project])->render() !!}
            
        @endforeach
    @endif
    
    <div class="project-box create-project-box">
        <form action="{{ route('bugtracker.create_project') }}" method="post" class="create-project-form" enctype="multipart/form-data">
            <div class="project-box-content">
                <div class="add-project-content" tabindex="1"><span>+</span></div>
                <div class="create-form-input-block">
                    <input name="project_name" class="project-title-input form-control" type="text" placeholder="@lang('projects.name_placeholder')" required>
                    <div class="help-block project_name"></div>
                    
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="project-box-image-block" style="display:inline-block;">
                    <div class="project-box-img">
                        <img class="image-update" src="{{ asset('images\default_project_thumb.jpg') }}" alt="">
                    </div>
                    <div class="image-input-block">
                        <input name="project_image" type="file" id="image-input" >
                        <label for="image-input"><span class="glyphicon glyphicon-picture"></span> @lang('custom.choose_image_file')</label>
                    </div>
                    
                </div>

                <div class="project-box-credentials">
                    <textarea name="project_description" class="project-description-textarea form-control" type="text" placeholder="@lang('projects.description_placeholder')" required></textarea>
                    
                </div>
                <div class="help-block project_description"></div>

                <span class="pull-right project-box-creator">
                    <span class="text-muted"><em><small>@lang('projects.creator_is')</small></em></span>
                    <span class="text-muted">{{ Auth::user()->name }}</span>
                    <img width="20px" src="{{ config('images.amazon_base_link') . config('images.user_avatar_dir') }}/{{ Auth::user()->profile_image }}" alt="profile image">
                </span>

            </div>
            <div class="project-box-open-btn">
                <button class="btn btn-success project-create-btn" type="submit" title="Create new project"><span class="glyphicon glyphicon-paperclip"></span> @lang('projects.create')</button>
            </div>
        </form>
    </div>
    </div>
    <div class="clearfix"></div>
    
@endsection
