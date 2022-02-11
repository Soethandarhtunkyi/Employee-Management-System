<?php

namespace App\Services\Payroll;

use Mail;
use App\Models\Employee;
use App\Models\FinalSalary;
use Illuminate\Http\Request;
use App\Jobs\SendPayrollMailJob;
use Illuminate\Support\Facades\Log;
use App\Contracts\Dao\Payroll\PayrollDaoInterface;
use App\Contracts\Services\Payroll\PayrollServiceInterface;
use PDF;
use Illuminate\Support\Facades\Storage;

/**
 * Service class for employee
 */
class PayrollService implements PayrollServiceInterface
{
    /**
     * employee dao
     */
    private $payrollDao;
    /**
     * Class Constructor
     * @param payrollDaoInterface
     * @return
     */
    public function __construct(PayrollDaoInterface $payrollDao)
    {
        $this->payrollDao = $payrollDao;
    }

    /**
     * To get employee lists
     * 
     * @return $array of employee
     */
    public function getEmployee()
    {
        return $this->payrollDao->getEmployee();
    }

    /**
     * To get employee lists
     * 
     * @return $array of employee
     */
    public function getEmployees()
    {
        return $this->payrollDao->getEmployees();
    }


    /**
     * To calculate pay roll
     * 
     * @param App\Models\Employee $employee
     * @return $final salary object
     */
    public function calculate(Employee $employee)
    {
        $data = $this->payrollDao->calculate($employee);
        $pdf = PDF::loadView('pdf.payroll', [
            'monthlyWorkingDays' => $data['monthlyWorkingDays'],
            'calculatedPayroll' => $data['calculatedPayroll']
        ]);
        Storage::put($data['calculatedPayroll']->file, $pdf->output());

        return $data;
    }

    /**
     * To calculate pay roll
     * 
     * @param App\Models\Employee $employee
     * @return $final salary object
     */
    public function recalculate(Employee $employee)
    {
        $data = $this->payrollDao->recalculate($employee);
        $pdf = PDF::loadView('pdf.payroll', [
            'monthlyWorkingDays' => $data['monthlyWorkingDays'],
            'calculatedPayroll' => $data['calculatedPayroll']
        ]);
        Storage::put($data['calculatedPayroll']->file, $pdf->output());

        return $data;
    }

    /**
     * Sending mail to employee.
     *
     * @param App\Models\FinalSalary $finalSalary
     * @return bool
     */
    public function sendPayrollMail(FinalSalary $finalsalary)
    {
        dispatch(new SendPayrollMailJob($finalsalary));
        // Check mail sending process has error.
        if (count(Mail::failures()) > 0) {
            Log::error('Mail Sending Error', Mail::failures());
        } else {
            return true;
        }
    }

    /**
     * To update employee payroll
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Models\Employee $employee
     * @return $employee object
     */
    public function updatePayroll(Request $request, Employee $employee)
    {
        return $this->payrollDao->updatePayroll($request, $employee);
    }
}
