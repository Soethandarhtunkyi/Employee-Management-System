<?php

namespace App\Contracts\Dao\Employee;

use Illuminate\Http\Request;
use App\Models\Employee;


/**
 * Interface for Data Accessing Object of employee
 */
interface EmployeeDaoInterface
{
    /**
     * To get list of roles
     *  @param
     *  @return $roles
     */
    public function getRoles();

    /**
     * To get list of departs
     *  @param
     *  @return $departs
     */
    public function getDepartments();

    /**
     * To add new employee
     * @param Request $request
     * @return $employee object
     */
    public function addEmployee(Request $request, $filename);

    /**
     * To get a employee by id
     * @param $id
     * @return Object $employee
     */
    public function getEmployeeById($id);

    /**
     * To edit employee information
     * @param $id,Request $request
     * @return $employee object
     */
    public function editEmployeeById(Request $request, $data);

    /**
     * To delete employee by id
     * @param $id
     * @return bool
     */
    public function deleteEmployeeById($id);

    /**
     * To search employee lists
     * 
     * @param Illuminate\Http\Request $request
     * @return $array of employee
     */

    /**
     * To upload csv file
     * @return File upload csv
     */
    public function uploadCSV();

    /**
     * To show employee
     * @return $array of employee
     */
    public function searchEmployee(Request $request);

    /**
     * To show graph
     * @return $array of employee
     */
    public function showPieGraph();

    /**
     * To show bar graph
     * @return $array of employee
     */
    public function showBarGraph();

    /**
     * To show total employee
     * @return $array of employee
     */
    public function allEmployee();

    /**
     * To show new employee
     * @return $array of employee
     */
    public function newEmployee();

    /**
     * To show turnover employee
     * @return $array of employee
     */
    public function turnoverEmployee();

    /**
     * To show employee who come to office
     * @return $array of employee
     */
    public function comeOfficeEmployee();

    /**
     * To get list of employees
     *  @param
     *  @return $employees
     */
    public function getExportEmployees();

    /**
     * To get list of managers
     *  @param
     *  @return $managers
     */
    public function getManagers();
}
