<?php

namespace App\Exports;

use App\Contracts\Dao\Employee\EmployeeDaoInterface;
use App\Models\Employee;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeesExport implements FromCollection, WithCustomCsvSettings, WithHeadings, ShouldAutoSize
{
    /**
     * employee dao
     */
    private $employeeDao;
    
    /**
     * Class Constructor
     * @param EmployeeDaoInterface
     * @return
     */
    public function __construct()
    {
        $this->employeeDao = app()->make(EmployeeDaoInterface::class);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Password',
            'Phone',
            'Address',
            'Profile',
            'Created_User_Id',
            'Role_Id',
            'Department_Id',
            'Created_at',
            'Updated_at'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->employeeDao->getExportEmployees();
    }
}
