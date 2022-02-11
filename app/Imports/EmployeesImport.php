<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class EmployeesImport implements ToModel, WithHeadingRow, WithStartRow, WithCustomCsvSettings, WithValidation
{
    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $employee = Employee::create([
            'name'  => $row['name'],
            'email' => $row['email'],
            'password' => $row['password'],
            'phone'    => $row['phone'],
            'address'    => $row['address'],
            'profile'    => $row['profile'],
            'created_user_id'    => $row['created_user_id'],
            'role_id'    => $row['role_id'],
            'department_id'    => $row['department_id'],
            'created_at'  => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
        $employee->salary()->create([
            'leave_fine' => 10000,
            'overtime_fee' => 10000,
            'basic_salary' => 500000
        ]);

        return $employee;
    }

    /**
     *
     * @return validation rules array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'password' => 'required|min:6',
            'phone' => [
                'required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:15', 'ends_with:0,1,2,3,4,5,6,7,8,9',
                function ($attribute, $value, $fail) {
                    if (Str::substrCount($value, '-',) > 1) {
                        $fail('The ' . $attribute . ' number must contain only one special character');
                    }
                },
                function ($attribute, $value, $fail) {
                    if (Str::substrCount($value, '+',) > 1) {
                        $fail('The ' . $attribute . ' number must contain only one special character');
                    }
                },
            ],
            'address' => 'required|max:255',
            'profile' => 'required',
            'role_id' => 'required|exists:mst_roles,id',
            'department_id' => 'required|exists:mst_departments,id',
            'created_user_id' => 'required|exists:employees,id,deleted_at,NULL'
        ];
    }
}
