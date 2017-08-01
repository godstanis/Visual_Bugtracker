@extends('emails.layouts.mail')

@section('title')
@lang('email.reset_title')
@endsection

@section('header')
@lang('email.reset_title')
@endsection

@section ('email-credentials')
@lang('email.email_credentials', [
    'user_email' => $user->email,
    'website_name' => 'bugwall.ru'
])
@endsection

@section('description')
<div>
    <p>@lang('email.hello'), {{ $user->name }}!</p>
    <p>
        @lang('email.reset_body', ['reset_link'=>$resetLink])
    </p>
    <hr>
    <p>
        <small>
            @lang('email.reset_warning')
        </small>
    </p>
</div>
@endsection
