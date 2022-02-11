<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Mail\EmployeeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Contracts\Dao\Employee\EmployeeDaoInterface;

class SendNewEmployee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * employee dao
     */
    private $employeeDao;

    /**
     * The employee instance.
     *
     * @var \App\Models\Employee
     */
    public $employee;

    /**
     * Create a new employee instance.
     *
     * @return void
     */
    public function __construct(Employee $employees)
    {
        $this->employee = $employees;
        $this->employeeDao = app()->make(EmployeeDaoInterface::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->employeeDao->getManagers();

        Mail::to($email)
            ->send(new EmployeeMail($this->employee));
    }
}
