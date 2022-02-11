<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The token variable.
     *
     * @var \App\Models\FinalSalary
     */
    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('employeemanagementsystem@gmail.com', config('constants.Name'))
            ->subject('Password Reset')
            ->markdown('mails.forgetPassword')
            ->with('token', $this->token);
    }
}
