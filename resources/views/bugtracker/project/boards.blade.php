@extends('layouts.project')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/board.css') }}" />
@endsection

@section('scripts')
<script src="{{ asset('js/bugtracker/boards.js') }}"></script>
@endsection

@section('head-scripts')
    <script src="{{ asset('js/bugtracker/projects.js') }}"></script>
    <script src="{{ asset('js/image-upload-input.js') }}"></script>
@endsection

@section('project-content')
    {!! Breadcrumbs::render('boards', $project) !!}
    <div class="boards-container">
        @if(!$boards->isEmpty())
            @foreach($boards as $board)
                @include('bugtracker.project.partials.board-box')
            @endforeach
        @endif
            <div class="board-box">
                    @include('bugtracker.project.partials.create-board-form')
            </div>
        <div class="clearfix"></div>
    </div>
@endsection
