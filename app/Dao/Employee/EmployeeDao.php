<?php

namespace App\Dao\Employee;

use App\Models\Salary;
use App\Models\MstRole;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\MstDepartment;
use Illuminate\Support\Carbon;
use App\Imports\EmployeesImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\Dao\Employee\EmployeeDaoInterface;

class EmployeeDao implements EmployeeDaoInterface
{
    /**
     * To get list of roles
     *  @param
     *  @return $roles
     */
    public function getRoles()
    {
        $roles = MstRole::all();
        return $roles;
    }

    /**
     * To get list of departs
     *  @param
     *  @return $departs
     */
    public function getDepartments()
    {
        $departments = MstDepartment::all();
        return $departments;
    }

    /**
     * To add new employee
     * @param Request $request
     * @return $employee object
     */
    public function addEmployee(Request $request, $filename)
    {
        try {
            DB::beginTransaction();

            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password);
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->profile = $filename;
            $employee->role_id = $request->role_id;
            $employee->created_user_id = auth()->id();
            $employee->department_id = $request->department_id;
            $employee->save();

            $salary = new Salary();
            $salary->employee_id = $request->employee;
            $salary->leave_fine = $request->leave_fine;
            $salary->overtime_fee = $request->overtime_fee;
            $salary->basic_salary = $request->basic_salary;

            $employee->salary()->save($salary);

            DB::commit();
            return $employee;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To get a employee by id
     * @param $id
     * @return Object $employee
     */
    public function getEmployeeById($id)
    {
        return Employee::with('role', 'department')->findOrFail($id);
    }

    /**
     * To edit employee information
     * @param $id,Request $request
     * @return $employee object
     */
    public function editEmployeeById(Request $request, $data)
    {
        $employee = Employee::findOrFail($data['id']);

        try {
            DB::beginTransaction();

            if ($data['filename']) {
                $employee->profile = $data['filename'];
            }
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'department_id' => $request->department_id,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            DB::commit();
            return $employee;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To delete employee by id
     * @param $id
     * @return bool
     */
    public function deleteEmployeeById($id)
    {
        try {
            DB::beginTransaction();

            Employee::find($id)->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To upload csv file
     * @return File upload csv
     */
    public function uploadCSV()
    {
        return Excel::import(new EmployeesImport, request()->file('file'));
    }

    /**
     * To search employee lists
     * 
     * @param Illuminate\Http\Request $request
     * @return $array of employee
     */
    public function searchEmployee(Request $request)
    {
        $name = $request->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $query = DB::table('employees')
            ->join('mst_roles', 'employees.role_id', '=', 'mst_roles.id')
            ->join('mst_departments', 'employees.department_id', '=', 'mst_departments.id')
            ->whereNull('employees.deleted_at')
            ->select('employees.*', 'mst_roles.name as role', 'mst_departments.name as department');

        $auth = DB::table('employees')
            ->join('mst_roles', 'employees.role_id', '=', 'mst_roles.id')
            ->join('mst_departments', 'employees.department_id', '=', 'mst_departments.id')
            ->whereNull('employees.deleted_at')
            ->where('employees.id', '<>', auth()->id())
            ->select('employees.*', 'mst_roles.name as role', 'mst_departments.name as department');

        $employees = DB::table('employees')
            ->join('mst_roles', 'employees.role_id', '=', 'mst_roles.id')
            ->join('mst_departments', 'employees.department_id', '=', 'mst_departments.id')
            ->whereNull('employees.deleted_at')
            ->where('employees.id', auth()->id())
            ->union($auth)
            ->select('employees.*', 'mst_roles.name as role', 'mst_departments.name as department');

        if ($name) {
            $employees = $query->where('employees.name', 'LIKE', '%' . $name . '%');
        }
        if ($start_date) {
            $employees = $query->whereDate('employees.created_at', '>=', $start_date);
        }
        if ($end_date) {
            $employees = $query->whereDate('employees.created_at', '<=', $end_date);
        }
        return $employees->paginate(10);
    }

    /**
     * To show graph
     * @return $array of employee
     */
    public function showPieGraph()
    {
        $record = Attendance::select(DB::raw("COUNT(*) as count"), DB::raw("(mst_departments.name) as department_name"), DB::raw("DAY(attendances.created_at) as day"))
            ->join('employees', 'attendances.employee_id', '=', 'employees.id')
            ->join('mst_departments', 'employees.department_id', '=', 'mst_departments.id')
            ->where('leave', 0)
            ->whereDate('attendances.created_at', Carbon::today())
            ->groupBy('department_name', 'day')
            ->orderBy('day')
            ->get();

        return $record;
    }

    /**
     * To show bar graph
     * @return $array of employee
     */
    public function showBarGraph()
    {
        $barrecord = Attendance::select(DB::raw("COUNT(*) as count"), DB::raw("(mst_departments.name) as department_name"), DB::raw("DAY(attendances.created_at) as day"))
            ->join('employees', 'attendances.employee_id', '=', 'employees.id')
            ->join('mst_departments', 'employees.department_id', '=', 'mst_departments.id')
            ->where('leave', 1)
            ->whereDate('attendances.created_at', Carbon::today())
            ->groupBy('department_name', 'day')
            ->orderBy('day')
            ->get();

        return $barrecord;
    }

    /**
     * To show total employee
     * @return $array of employee
     */
    public function allEmployee()
    {
        $totalemployee = Employee::select(DB::raw("COUNT(*) as count"))
            ->whereNull('deleted_at')
            ->get();

        return $totalemployee;
    }

    /**
     * To show new employee
     * @return $array of employee
     */
    public function newEmployee()
    {
        $newemployee = Employee::select(DB::raw("COUNT(*) as count"))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereNull('deleted_at')
            ->get();

        return $newemployee;
    }

    /**
     * To show turnover employee
     * @return $array of employee
     */
    public function turnoverEmployee()
    {
        $employeeleave = Employee::select(DB::raw("COUNT(*) as count"))
            ->whereMonth('deleted_at', Carbon::now()->month)
            ->onlyTrashed()
            ->get();

        return $employeeleave;
    }

    /**
     * To show employee who come to office
     * @return $array of employee
     */
    public function comeOfficeEmployee()
    {
        $officeemployee = Attendance::select(DB::raw("COUNT(*) as count"))
            ->join('employees', 'attendances.employee_id', '=', 'employees.id')
            ->where('type', config('constants.Office'))
            ->whereDate('attendances.created_at', Carbon::today())
            ->get();

        return $officeemployee;
    }

    /**
     * To get list of employees
     *  @param
     *  @return $employees
     */
    public function getExportEmployees()
    {
        return Employee::select(
            [
                'name',
                'email',
                'password',
                'phone',
                'address',
                'profile',
                'created_user_id',
                'role_id',
                'department_id',
                'created_at',
                'updated_at'
            ]
        )
        ->get()
        ->makeVisible(['password']);
    }

    /**
     * To get list of managers
     *  @param
     *  @return $managers
     */
    public function getManagers()
    {
        return DB::table('employees')
            ->join('mst_roles', 'employees.role_id', '=', 'mst_roles.id')
            ->where('mst_roles.name', 'Manager')
            ->select('employees.*')
            ->get();
    }
}
