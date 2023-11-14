<?php

namespace App\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailVerificationNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Verify your email address')
                    ->markdown('emails.verify')
                    ->with([
                        'user' => $this->user,
                        'url' => URL::temporarySignedRoute(
                            'verification.verify', now()->addMinutes(60), ['id' => $this->user->id]
                        ),
                    ]);
    }
}