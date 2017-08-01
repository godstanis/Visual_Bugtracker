
@extends('errors.layout')

@section('error-content')

    <h1>@lang('errors.oops')</h1>
    <img src="{{asset('images/errors/oops-error.svg')}}" width="120px" height="120px" alt="Oops!">
    <h3>@lang('errors.page_not_found') :(</h3>
    <button class="btn btn-warning btn-xs" data-toggle="collapse" data-target="#not_authorized_help_body">
        <span class="glyphicon glyphicon-question-sign"></span>
        <span>@lang('errors.help_title')</span>
    </button>

    <div id="not_authorized_help_body" class="collapse">
        @lang('errors.page_not_found_help_text')
        <hr>
        @lang('errors.help_contact_us')
    </div>

@endsection

