@extends('user.layouts.main')

@section('user-page-content')

    <div class="span2 text-center">
        <img class="user-profile-image" src="{{$user->imageLink()}}" width="124px">
    </div>
    <div class="span8">
        <h5>Email: {{$user->email}}</h5>
    </div>

@endsection