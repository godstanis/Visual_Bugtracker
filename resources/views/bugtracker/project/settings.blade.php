@extends('layouts.project')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/projects.css') }}" />
@endsection

@section('scripts')
<script src="{{ asset('js/image-upload-input.js') }}"></script>
@endsection

@section('project-content')
{!! Breadcrumbs::render('settings', $project) !!}

<div class="col-md-6 col-md-offset-3">
    <form action="" method="POST">
        
        <div class="project-box-image-block" style="display:inline-block;">
            <div class="project-box-img">
                <img class="image-update" src="{{ $project->thumbnailUrl() }}" alt="Project image">

            </div>
            <div class="image-input-block">
                <input name="thumbnail_image" type="file" id="image-input" >
                <label for="image-input"><span class="glyphicon glyphicon-picture"></span> @lang('custom.choose_image_file')</label>
            </div>
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <br>
        <label for="project-name">Name:</label>
        <input id="project-name" class="form-control" type="text" name="name" placeholder="@lang('projects.name_placeholder')" value="{{$project->name}}">
        <label for="project-description">Description:</label>
        <textarea id="project-description" name="description" class="project-description-textarea form-control" type="text" placeholder="@lang('projects.description_placeholder')" required>{{$project->description}}</textarea>
        <hr>
        <input id="project-url" class="form-control" type="text" name="website_url" placeholder="website url" value="{{$project->website_url}}">
        <br>
        <button class="btn btn-success">Save</button>
    </form>
</div>
<br>


@endsection
