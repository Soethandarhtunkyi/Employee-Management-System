<?php

namespace App\Mail;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTaskNotiMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The schedule instance.
     *
     * @var \App\Models\Schedule $schedule
     */
    public $schedule;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('employeemanagementsystem@gmail.com', config('constants.Name'))
            ->subject('New Task Notify')
            ->markdown('mails.newtask')
            ->with('schedule', $this->schedule);
    }
}
