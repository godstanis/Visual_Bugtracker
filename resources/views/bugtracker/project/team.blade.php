@extends('layouts.project')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/project.css') }}" />
<link rel="stylesheet" href="{{ asset('css/bugtracker/team.css') }}" />
@endsection

@section('scripts')
<!-- Passing the policy to js -->
<script>
    (function() {
        window.auth_user = {};
        window.auth_user.canManage = false;
        window.auth_user.canRemoveMember = false;
        @can('delete', $project)
            window.auth_user.canRemoveMember = true;
        @endcan
        @can('manage', $project)
            window.auth_user.canManage = true;
        @endcan
    })();
</script>
@endsection

@section('project-content')
    {!! Breadcrumbs::render('team', $project) !!}
    <div id="search-team-component"></div><!-- see react TeamComponent.js -->
@endsection
