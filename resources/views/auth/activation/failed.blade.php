@extends('layouts.app')

@section('content')
<div class="alert alert-danger text-center">
    <h2>@lang('auth.activation_failed')</h2>
    <hr>
    <span>@lang('auth.problems_with_activation_question') <a href="mailto:contact@bugwall.ru">contact@bugwall.ru</a></span>
</div>
@endsection