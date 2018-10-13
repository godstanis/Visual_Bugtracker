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

<ul class="nav nav-tabs nav-justified project-navigation-menu-bar">
    <li>
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.issues', ['project' => $project]) }}"><span class="glyphicon glyphicon-remove-circle"></span> <span class="navigation-text">@lang('projects.issues')</span></a>
    </li>
    <li>
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.boards', ['project' => $project]) }}"><span class="glyphicon glyphicon-blackboard"></span> <span class="navigation-text">@lang('projects.boards')</span></a>

    </li>
    <li>
        <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.team', ['project' => $project]) }}"><span class="glyphicon glyphicon-user"></span> <span class="navigation-text">@lang('projects.team')</span></a>

    </li>
    @can('update', $project)
    <li>
            <a class="btn btn-bg btn-default open-tab-btn" href="{{ route('project.settings', ['project' => $project]) }}"><span class="glyphicon glyphicon-cog"></span> <span class="navigation-text">@lang('projects.settings')</span></a>
    </li>
    @endcan
</ul>

<div class="container project-tab-container col-md-12">
    @yield('project-content')
</div>
@endsection