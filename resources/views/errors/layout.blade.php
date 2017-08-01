
@extends('layouts.app')

@section('head-styles')
<style>
    .alert{
        margin-top: 30%;
    }

</style>
@endsection

<div>
    <div class="col-md-offset-4 col-md-4">
    <div class="alert alert-warning text-center error-box">
    
        @yield('error-content')
        <hr>
        <a class="btn btn-success" href="{{ redirect()->back()->getTargetUrl() }}"><< @lang('errors.go_back') <<</a>
    </div>
</div>
    
</div>

