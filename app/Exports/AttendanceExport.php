<?php

namespace App\Exports;

use App\Contracts\Dao\Attendance\AttendanceDaoInterface;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class AttendanceExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;
    
    /**
     * attendance dao
     */
    private $attendanceDao;

    /**
     * Class Constructor
     * @param StidentDaoInterface
     * @return
     */
    public function __construct(AttendanceDaoInterface $attendanceDao)
    {
        $this->attendanceDao = $attendanceDao;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->attendanceDao->getMonthlyAttendances();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Role',
            'Department',
            'Working Days',
            'Leave'
        ];
    }

    /**
    * @var Invoice $invoice
    */
    public function map($employee): array
    {
        return [
            $employee->name,
            $employee->email,
            $employee->role->name,
            $employee->department->name,
            $employee->working_days,
            $employee->leave_days
        ];
    }
}
