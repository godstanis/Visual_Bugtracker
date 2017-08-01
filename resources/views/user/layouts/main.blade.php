@extends('layouts.app')

@section('head-scripts')
<script src="{{ asset('js/image-upload-input.js') }}"></script>
@endsection

@section('content')
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>{{$userName}}</h4>
        </div>
        <div class="panel-body">

            @yield('user-page-content')
            <hr>
            <div class="user-stats">
                @include('user.partials.stats')
            </div>

        </div>

    </div>
</div>
@endsection