<?php

namespace App\Dao\Payroll;

use App\Models\Employee;
use App\Models\MstCalender;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Contracts\Dao\Payroll\PayrollDaoInterface;
use App\Models\FinalSalary;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Payroll
 */
class PayrollDao implements PayrollDaoInterface
{
    /**
     * To get employee lists
     * 
     * @return $array of employee
     */
    public function getEmployee()
    {
        $authUser = auth()->user()
            ->load('role', 'department', 'salary');

        $sortedEmployees = Employee::where('id', '<>', auth()->id())
            ->with('role', 'department', 'salary')
            ->orderBy('created_at', 'asc')
            ->get();

        return $sortedEmployees->prepend($authUser);
    }

    /**
     * To get employee lists
     * 
     * @return $array of employee
     */
    public function getEmployees()
    {
        return Employee::all();
    }


    /**
     * To get employee lists
     * 
     * @param App\Models\Employee
     * @return fintal salary object
     */
    public function calculate(Employee $employee)
    {
        // Actual working days for this month.
        $monthlyWorkingDays = MstCalender::select('working_days')
            ->where('month', Carbon::now()->month)
            ->where('year', Carbon::now()->year)
            ->first()
            ->working_days;

        $calculatedPayroll = $employee->finalsalaries()
            ->where('month', Carbon::now()->month)
            ->where('year', Carbon::now()->year)
            ->first();

        // Check payroll for this month is already calculated or not.
        if ($calculatedPayroll) {
            $calculatedPayroll->load('employee', 'employee.role', 'employee.department');
            return [
                'monthlyWorkingDays' => $monthlyWorkingDays,
                'calculatedPayroll' => $calculatedPayroll
            ];
        } else {
            $emptotalWorkingHours = $employee->attendances()
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereNotNull('working_hours')
                ->sum('working_hours');

            $calculated = payrollCalculate($monthlyWorkingDays, $emptotalWorkingHours, $employee);

            $payroll = DB::transaction(function () use ($employee, $calculated, $emptotalWorkingHours) {
                return $employee->finalsalaries()
                    ->create([
                        'year' => Carbon::now()->year,
                        'month' => Carbon::now()->month,
                        'total_leave_days' => $employee->leave_days,
                        'total_leave_fines' => round($calculated['totalLeaveFines'], 2),
                        'total_overtimes' => round($employee->overtimes, 1),
                        'total_overtime_fees' => round($calculated['totalOverTimeFees'], 2),
                        'total_working_hours' => round($emptotalWorkingHours, 1),
                        'salary' => round($calculated['finalSalary'], 2),
                        'file' => $calculated['filePath']
                    ]);
            }, 5);

            $payroll->load('employee', 'employee.role', 'employee.department');

            return [
                'monthlyWorkingDays' => $monthlyWorkingDays,
                'calculatedPayroll' => $payroll
            ];
        }
    }

    /**
     * To calculate pay roll
     * 
     * @param App\Models\Employee $employee
     * @return $array of employee
     */
    public function recalculate(Employee $employee)
    {
        // Actual working days for this month.
        $monthlyWorkingDays = MstCalender::select('working_days')
            ->where('month', Carbon::now()->month)
            ->where('year', Carbon::now()->year)
            ->first()
            ->working_days;

        $calculatedPayroll = $employee->finalsalaries()
            ->where('month', Carbon::now()->month)
            ->where('year', Carbon::now()->year)
            ->first();

        $emptotalWorkingHours = $employee->attendances()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereNotNull('working_hours')
            ->sum('working_hours');

        $calculated = payrollCalculate($monthlyWorkingDays, $emptotalWorkingHours, $employee);

        DB::transaction(function () use ($employee, $calculatedPayroll, $calculated, $emptotalWorkingHours) {
            $calculatedPayroll->update([
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'total_leave_days' => $employee->leave_days,
                'total_leave_fines' => round($calculated['totalLeaveFines'], 2),
                'total_overtimes' => round($employee->overtimes, 1),
                'total_overtime_fees' => round($calculated['totalOverTimeFees'], 2),
                'total_working_hours' => round($emptotalWorkingHours, 1),
                'salary' => round($calculated['finalSalary'], 2),
                'file' => $calculated['filePath']
            ]);
        }, 5);

        $calculatedPayroll->load('employee', 'employee.role', 'employee.department');

        return [
            'monthlyWorkingDays' => $monthlyWorkingDays,
            'calculatedPayroll' => $calculatedPayroll
        ];
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
        $employee = DB::transaction(function () use ($request, $employee) {
            return $employee->salary()
                ->update($request->except('_token', '_method'));
        });

        return $employee;
    }
}
