@extends('layouts.project')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/board.css') }}" />
@endsection
@section('scripts')
<script src="{{ asset('js/bugtracker/boards.js') }}"></script>
@endsection
@section('project-content')
{!! Breadcrumbs::render('boards', $project) !!}

<div class="boards-container">
@if(!$boards->isEmpty())
    @foreach($boards as $board)
        @include('bugtracker.project.partials.board-box')
    @endforeach
@else
    <a class="btn btn-info" href="{{route('project.editor', ['project'=>$project])}}">Editor</a>
@endif
</div>

@endsection
