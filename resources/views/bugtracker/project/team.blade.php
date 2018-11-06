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
        @can('delete', $project)
            window.auth_user.canRemoveMember = true;
        @else
            window.auth_user.canRemoveMember = false;
        @endcan
    })();
</script>
@endsection

@section('project-content')
    {!! Breadcrumbs::render('team', $project) !!}
    <!-- TODO: This is for testing purposes only, it will be removed/changed in future-->
    <form method="POST" action="{{route('project.team.allow', compact('project'))}}">
        <input type="text" name="user" placeholder="user name">
        <input type="text" name="ability_name" placeholder="ability name">
        <input type="text" name="_token" hidden value="{{csrf_token()}}">
        <button type="submit">Set permission</button>
    </form>
    <div id="search-team-component"><!-- see react TeamComponent.js -->
@endsection
