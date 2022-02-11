<?php

namespace App\Services\Attendance;

use App\Contracts\Dao\Attendance\AttendanceDaoInterface;
use App\Contracts\Services\Attendance\AttendanceServiceInterface;
use Illuminate\Http\Request;

/**
 * Service class for attendance.
 */
class AttendanceService implements AttendanceServiceInterface
{
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
     * To get attendance lists
     * @return $array of attendances
     */
    public function getAttendances()
    {
        return $this->attendanceDao->getAttendances();
    }

    /**
     * To store daily attendance record
     * @return attendance object
     */
    public function saveAttendance(Request $request)
    {
        return $this->attendanceDao->saveAttendance($request);
    }

    /**
     * To update daily attendance record
     * @return attendance object
     */
    public function updateAttendance()
    {
        return $this->attendanceDao->updateAttendance();
    }

    /**
     * To store custom leave record
     * @return collection of $attendances
     */
    public function saveCustomLeave(Request $request)
    {
        return $this->attendanceDao->saveCustomLeave($request);
    }

    /**
     * To get attendance status
     * @return int type of none, checkedin, checkedout
     */
    public function getAttendanceStatus()
    {
        return $this->attendanceDao->getAttendanceStatus();
    }
}
