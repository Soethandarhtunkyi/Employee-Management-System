<?php

namespace App\Mail;

use App\Models\FinalSalary;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeePayroll extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The finalsalary instance.
     *
     * @var \App\Models\FinalSalary
     */
    public $finalsalary;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FinalSalary $finalsalary)
    {
        $this->finalsalary = $finalsalary;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('employeemanagementsystem@gmail.com', config('constants.Name'))
            ->subject('Payroll Notify')
            ->markdown('mails.payroll')
            ->attachFromStorage($this->finalsalary->file);
    }
}
