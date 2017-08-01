@extends('emails.layouts.mail')

@section('title')
BugWall registration
@endsection

@section('header')
@lang('email.welcome_to_our_team')
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
        @lang('email.successfuly_registered', [
            'website_link'=>'<a href="http://bugwall.ru/">BugWall.ru</a>',
            'confirm_link'=> route('account.activation', ['token'=>$token]),
        ])

    </p>
</div>
@endsection