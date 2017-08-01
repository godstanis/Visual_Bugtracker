@extends('layouts.app')
@section('head-styles')
<link rel="stylesheet" href="css/home-page.css">
@endsection
@section('content')

<div class="container">
    <h1 class="text-center">@lang('Welcome to the site')</h1>
    
    <hr>
    @if (Auth::guest())
    <div>
        <a class="btn btn-success btn-lg col-md-5 col-xs-12" href="{{ route('login') }}">@lang('auth.login')</a>
        <div class="visible-xs">
            <br><br><br>
        </div>
        <a class="btn btn-success btn-lg col-md-5 col-md-offset-2 col-xs-12" href="{{ route('register') }}">@lang('auth.register')</a>
    </div>
        
    @else
    
    <div class="control-group">
        <a class="btn btn-success btn-lg col-md-2 col-md-offset-5 col-xs-12" href="{{ route('bugtracker.projects') }}">@lang('projects.my_projects')</a>
    </div>
    
    @endif
</div>

@endsection
