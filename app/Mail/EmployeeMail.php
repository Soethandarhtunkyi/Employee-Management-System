<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Employee $employees)
    {
        $this->employee = $employees;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('employeemanagementsystem@gmail.com', config('constants.Name'))
            ->subject('New Employee Registered Notify')
            ->markdown('mails.newemployee')
            ->with('employee', $this->employee);
    }
}
