@extends('layouts.app')

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
            @include('bugtracker.project.partials.create-project-form')
        </div>
    </div>
    <div class="clearfix"></div>
@endsection
