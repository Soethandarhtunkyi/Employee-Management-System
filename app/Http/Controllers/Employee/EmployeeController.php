<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Exports\EmployeesExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\EditEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Contracts\Services\Employee\EmployeeServiceInterface;
use App\Http\Requests\ImportEmployeesRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * task interface
     */
    private $employeeInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmployeeServiceInterface $employeeServiceInterface)
    {
        $this->employeeInterface = $employeeServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = $this->employeeInterface->searchEmployee($request);
        return view('employees.index')
            ->with(['employees' => $employees]);
    }

    /**
     * To redirect new employee information form
     * @param
     * @return view
     */
    public function create()
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $roles = $this->employeeInterface->getRoles();
        $departments = $this->employeeInterface->getDepartments();

        return view('employees.employeeCreate')
            ->with([
                'roles' => $roles,
                'departments' => $departments
            ]);
    }

    /**
     * To save new employee
     * 
     * @param App\Http\Requests\StoreEmployeeRequest $request
     * @return massage success or not
     */
    public function submitEmployeeForm(StoreEmployeeRequest $request)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $employee = $this->employeeInterface->addEmployee($request);

        if ($this->employeeInterface->sendEmployeeMail($employee)) {
            return redirect()
                ->route('employee-showLists')
                ->with('success', 'New Employee Created and Email has been sent to Managers.');
        }

        return back()
            ->withErrors('Unknown error occured! Please try again.');
    }

    /**
     * To redirect employee edit information form
     * @param
     * @return view
     */
    public function showEmployeeDetailForm($id)
    {
        $employee = $this->employeeInterface->getEmployeeById($id);
        return view('employees.employeeShow')
            ->with(['employee' => $employee]);
    }

    /**
     * To redirect employee edit information form
     * @param $id
     * @return view
     */
    public function showEmployeeEditForm($id)
    {
        // Check user own profile or user has manager role.
        if (Gate::denies('update-employee', $id)) {
            abort(401);
        }

        $roles = $this->employeeInterface->getRoles();
        $departments = $this->employeeInterface->getDepartments();

        $employee = $this->employeeInterface->getEmployeeById($id);
        return view('employees.employeeEdit')
            ->with([
                'employee' => $employee,
                'roles' => $roles,
                'departments' => $departments
            ]);
    }

    /**
     * To update employee information
     * @param App\Http\Requests\StoreEmployeeRequest $request
     * @param $id
     * @return message success or not
     */
    public function submitEmployeeEditForm(EditEmployeeRequest $request, $id)
    {
        // Check user own profile or user has manager role.
        if (Gate::denies('update-employee', $id)) {
            abort(401);
        }

        $employee = $this->employeeInterface->editEmployeeById($request, $id);

        if ($employee) {
            return redirect()
                ->route('employee-showLists')
                ->with('success', 'Employee data is updated successfully.');
        }

        return back()
            ->withErrors('Unknown error occured! Please try again.');
    }

    /**
     * To delete employee by id
     * @param employee id
     * @return message success or not
     */
    public function deleteEmployee($id)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        $result = $this->employeeInterface->deleteEmployeeById($id);

        if ($result) {
            return redirect()
                ->route('employee-showLists')
                ->with('success', 'Employee data is deleted successfully.');
        }

        return back()
            ->withErrors('Unknown error occured! Please try again.');
    }

    /**
     * Display chart data.
     *
     * @return \Illuminate\Http\Response
     */
    public function graph()
    {
        $data = $this->employeeInterface->showPieGraph();
        $bardata = $this->employeeInterface->showBarGraph();
        $totalemployee = $this->employeeInterface->allEmployee();
        $newemployee = $this->employeeInterface->newEmployee();
        $employeeleave = $this->employeeInterface->turnoverEmployee();
        $officeemployee = $this->employeeInterface->comeOfficeEmployee();
        return view('dashboard.index', $data, $bardata)
            ->with(
                ['totalemployee' => $totalemployee,
                'newemployee' => $newemployee,
                'employeeleave' => $employeeleave,
                'officeemployee' => $officeemployee
            ]);
    }

    /**
     * To download csv file
     * @return File Download CSV file
     */
    public function downloadCSV()
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        return Excel::download(new EmployeesExport, 'form.xlsx');
    }

    /**
     * Show the form of upload file
     *
     * @return \Illuminate\Http\Response
     */
    public function showUpload()
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        return view('employees.upload');
    }

    /**
     * Import the csv file
     * 
     * @param \App\Http\Requests\ImportEmployeesRequest $request 
     * @return \Illuminate\Http\Response
     */
    public function submitUpload(ImportEmployeesRequest $request)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        if ($this->employeeInterface->uploadCSV()) {
            return redirect()
                ->route('employee-showLists')
                ->with('success', 'Successfully Imported CSV File.');
        }
    }
}
