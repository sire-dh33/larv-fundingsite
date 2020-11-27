<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\SendOtpCodeMail;
use Mail;

class SendEmailOtpCode implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if ($event->condition == 'register') {
            $message = "We're excited to have you get started. First, you need to confirm you account. This is you OTP Code : ";
        }
        else if ($event->condition == 'regenerate') {
            $message = "Regenerate OTP Successful. This is your OTP Code : ";
        }

        Mail::to($event->user)->send(new SendOtpCodeMail($event->user , $message));
    }
}
