<?php

namespace App\Jobs;

use Mail;
use App\Models\FinalSalary;
use App\Mail\EmployeePayroll;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendPayrollMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The finalsalary instance.
     *
     * @var \App\Models\FinalSalary
     */
    public $finalsalary;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FinalSalary $finalsalary)
    {
        $this->finalsalary = $finalsalary;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->finalsalary->employee->email)
            ->send(new EmployeePayroll($this->finalsalary));
    }
}
