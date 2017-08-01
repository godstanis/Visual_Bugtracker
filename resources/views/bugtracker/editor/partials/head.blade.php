
@section('head-scripts')
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

<script src="{{ asset('js/bugtracker/boards.js') }}"></script>

<script src="{{asset('editor/js/src/draw.svg.js')}}"></script>
<script src="{{asset('editor/js/src/draw.svg.editor.js')}}"></script>
<script src="{{asset('editor/js/src/draw.svg.data-constructor.js')}}"></script>


<script src="{{asset('editor/js/jscolor.min.js')}}"></script>
<script src="{{asset('editor/js/jquery.mousewheel.min.js')}}"></script>

<script src="{{ asset('js/bugtracker/issues.js') }}"></script>

@endsection

@section('head-styles')
<link rel="stylesheet" type="text/css" href="{{asset('editor/css/style.editor.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('editor/css/boards.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('editor/css/radio-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('editor/css/marker-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('editor/css/json-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('editor/css/sprite-style.css')}}">
@endsection

@include('layouts.partials.head')
