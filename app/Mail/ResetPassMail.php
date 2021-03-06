<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($activeLink, $username, $password)
    {
        $this->activeLink = $activeLink;
        $this->username = $username;        
        $this->password = $password;        
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Đặt lại mật khẩu')
                    ->view('mail.reset')
                    ->with([
                        'activeLink' => $this->activeLink,
                        'username' => $this->username,
                        'password' => $this->password,
                    ]);
    }}
