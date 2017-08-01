<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $user_activation_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, $user_activation_token)
    {
        $this->user = $user;
        $this->user_activation_token = $user_activation_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('email.registered_subject'))
        ->view('emails.registered', ['user'=>$this->user, 'token'=>$this->user_activation_token]);
    }
}
