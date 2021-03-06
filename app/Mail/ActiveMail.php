<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActiveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($activeLink, $name)
    {
        $this->activeLink = $activeLink;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Kích hoạt tài khoản mới')
                    ->view('mail.active')
                    ->with([
                        'active_link' => $this->activeLink,
                        'name' => $this->name
                    ]);
    }
}
