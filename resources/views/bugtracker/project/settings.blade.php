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
    <form action="" method="POST" enctype="multipart/form-data">
        
        <div class="project-box-image-block" style="display:inline-block;">
            <div class="project-box-img">
                <img class="image-update" src="{{ $project->thumbnailUrl() }}" alt="Project image">

            </div>
            <div class="image-input-block">
                <input name="image" type="file" id="image-input" >
                <label for="image-input"><span class="glyphicon glyphicon-picture"></span> @lang('custom.choose_image_file')</label>
            </div>
            @if ($errors->has('image'))
                <span class="help-block">
                <strong>{{ $errors->first('image') }}</strong>
            </span>
            @endif
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <br>
        <label for="project-name">Name:</label>
        <input id="project-name" class="form-control" type="text" name="name" placeholder="@lang('projects.name_placeholder')" value="{{$project->name}}">
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
        <label for="project-description">Description:</label>
        <textarea id="project-description" name="description" class="project-description-textarea form-control" type="text" placeholder="@lang('projects.description_placeholder')" required>{{$project->description}}</textarea>
        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
        <hr>
        <input id="project-url" class="form-control" type="text" name="website_url" placeholder="website url" value="{{$project->website_url}}">
        @if ($errors->has('website_url'))
            <span class="help-block">
                <strong>{{ $errors->first('website_url') }}</strong>
            </span>
        @endif
        <br>
        <button class="btn btn-success">Save</button>
    </form>
</div>
<br>


@endsection
