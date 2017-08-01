@extends('layouts.bugtracker')

@section('head-styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/project.css') }}" />
@yield('styles')
@endsection

@section('head-scripts')
<script src="{{ asset('js/bugtracker/project.js') }}"></script>
@yield('scripts')
@endsection


@section('content')
<!-- {!! Breadcrumbs::render('project', $project) !!} -->

<div class="container col-md-12 bugtracker-content-container">
    
    <div class="col-md-12 btn-group btn-group-justified project-navigation-menu-bar">
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.issues', ['project' => $project]) }}"><span class="glyphicon glyphicon-remove-circle"></span> <span class="navigation-text">@lang('projects.issues')</span></a>
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.boards', ['project' => $project]) }}"><span class="glyphicon glyphicon-blackboard"></span> <span class="navigation-text">@lang('projects.boards')</span></a>
        <!-- TODO
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.activity', ['project' => $project]) }}"><span class="glyphicon glyphicon-stats"></span> <span class="navigation-text">@lang('projects.activity')</span></a>
        -->
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.team', ['project' => $project]) }}"><span class="glyphicon glyphicon-user"></span> <span class="navigation-text">@lang('projects.team')</span></a>
        @can('delete', $project)
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.settings', ['project' => $project]) }}"><span class="glyphicon glyphicon-cog"></span> <span class="navigation-text">@lang('projects.settings')</span></a>
        @endcan
    </div>

    <div class="container project-tab-container col-md-12">
        @yield('project-content')
    </div>

</div>
        
@endsection