<?php

use App\Models\Employee;
use Illuminate\Support\Carbon;

/**
 * To calculate payroll
 * 
 * @param int $monthlyWorkingDays
 * @param int $emptotalWorkingHours
 * @param \App\Models\Employee $employee
 * @return array
 */
function payrollCalculate($monthlyWorkingDays, $emptotalWorkingHours, $employee)
{
    $basicSalaryPerHours = ($employee->salary->basic_salary / $monthlyWorkingDays)
        / config('constants.Actual_Working_Hours');
    $empOfficialHours = ($emptotalWorkingHours + ($employee->leave_days *
        config('constants.Actual_Working_Hours'))) - $employee->overtimes;
    $calculated['totalLeaveFines'] = $employee->leave_days * $employee->salary->leave_fine;
    $calculated['totalOverTimeFees'] = $employee->overtimes * $employee->salary->overtime_fee;
    $calculated['finalSalary'] = (($empOfficialHours * $basicSalaryPerHours)
        + $calculated['totalOverTimeFees']) - $calculated['totalLeaveFines'];
    $calculated['filePath'] = 'payroll' . config('path.separator') . Carbon::now()->month . '_'
        . Carbon::now()->year . config('path.separator') . $employee->name . '_payroll.pdf';

    return $calculated;
}
