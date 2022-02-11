<?php

namespace App\Contracts\Dao\Payroll;

use Illuminate\Http\Request;
use App\Models\Employee;

/**
 * Interface for Data Accessing Object of Payroll
 */
interface PayrollDaoInterface
{
    /**
     * To get employee lists
     * 
     * @return $array of employee
     */
    public function getEmployee();

    /**
     * To get employee lists
     * 
     * @return $array of employee
     */
    public function getEmployees();

    /**
     * To get employee lists
     * 
     * @param App\Models\Employee
     * @return fintal salary object
     */
    public function calculate(Employee $employee);

    /**
     * To calculate pay roll
     * 
     * @param App\Models\Employee $employee
     * @return $array of employee
     */
    public function recalculate(Employee $employee);

    /**
     * To update employee payroll
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Models\Employee $employee
     * @return $employee object
     */
    public function updatePayroll(Request $request, Employee $employee);
}
