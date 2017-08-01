@extends('layouts.app')

@section('content')
<div class="alert alert-success text-center">
    <h2>@lang('auth.activation_success')</h2>
    <hr>
    <a class="btn btn-success" href="{{route('login')}}">@lang('auth.login')</a>
</div>
@endsection