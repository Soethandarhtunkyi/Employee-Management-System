<?php

namespace App\Console\Commands;

use App\Contracts\Services\Payroll\PayrollServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendPayroll extends Command
{
    /**
     * task interface
     */
    private $payrollInterface;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payrolls:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the payrolls to each employee every month.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PayrollServiceInterface $payrollServiceInterface)
    {
        parent::__construct();

        $this->payrollInterface = $payrollServiceInterface;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $employees = $this->payrollInterface->getEmployees();
        $errorCount = 0;

        foreach ($employees as $employee) {
            // Calculate the payroll of each user;
            $firstCalculated = $this->payrollInterface->calculate($employee);
            $finalCalculated = $this->payrollInterface->recalculate($employee);

            // Send payroll mail to each user and check if any errors.
            if (!$this->payrollInterface->sendPayrollMail($finalCalculated['calculatedPayroll'])) {
                $errorCount ++ ;
            }
        }

        if ($errorCount > 0) {
            Log::info('Payroll Sending Error', ['errors' => 'There were some errors with sending email to employees.']);
        }
    }
}
