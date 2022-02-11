<?php

namespace App\Http\Controllers\Payroll;

use App\Contracts\Services\Payroll\PayrollServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePayrollRequest;
use App\Models\Employee;
use App\Models\FinalSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PayrollController extends Controller
{
    /**
     * task interface
     */
    private $payrollInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PayrollServiceInterface $payrollServiceInterface)
    {
        $this->payrollInterface = $payrollServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $employees = $this->payrollInterface->getEmployee();

        return view('payrolls.index')
            ->with(['employees' => $employees]);
    }

    /**
     * Calculate the payroll of employee.
     *
     * @param App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function calculate(Employee $employee)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $data = $this->payrollInterface->calculate($employee);

        return view('payrolls.calculate')
            ->with($data);
    }

    /**
     * Recalculate the payroll of employee.
     *
     * @param App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function recalculate(Employee $employee)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $data = $this->payrollInterface->recalculate($employee);

        return view('payrolls.calculate')
            ->with($data);
    }

    /**
     * Sending mail to employee.
     *
     * @param App\Models\FinalSalary $finalSalary
     * @return \Illuminate\Http\Response
     */
    public function sendPayrollMail(FinalSalary $finalsalary)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        if ($this->payrollInterface->sendPayrollMail($finalsalary)) {
            return redirect()
                ->route('payrolls-index')
                ->with('success', 'Email has been sent.');
        }
    }

    /**
     * Show the edit view.
     *
     * @param App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function showEditView(Employee $employee)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $employee->load('salary');

        return view('payrolls.edit')
            ->with(['employee' => $employee]);
    }

    /**
     * Update the basic salary of employee.
     *
     * @param App\Http\Requests\UpdatePayrollRequest $request
     * @param App\Models\Employee $employee
     * @return \Illuminate\Http\Response
     */
    public function updatePayroll(UpdatePayrollRequest $request, Employee $employee)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $employee = $this->payrollInterface->updatePayroll($request, $employee);

        if ($employee) {
            return redirect()
                ->route('payrolls-index')
                ->with('success', 'Employee payroll edited successfully.');
        }
        
        return back()
            ->withErrors('Unknown error occured! Please try again.');
    }
}
