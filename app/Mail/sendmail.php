<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendmail extends Mailable
{
    use Queueable, SerializesModels;

    public $maildetails;
    public $securitycode;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildetails, $securitycode)
    {
        $this->maildetails = $maildetails;
        $this->securitycode = $securitycode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if ($this->securitycode == "pin") {
            return $this->subject('Verify Your Pin')->view('mail');
        } else {
            return $this->subject('Verify Your Email')->view('mail_link');
        }

    }
}