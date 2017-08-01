<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\User $user, $token)
    {
        $this->token = $token;
        $this->user = $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $resetLink = route('password.reset', ['token'=>$this->token]);
        $user = $this->user;

        return $this->subject(trans('email.reset_subject'))
            ->view('emails.reset-password-notification', compact('resetLink', 'user'));
    }
}
