<?php

namespace App\Contracts\Dao\Attendance;

use Illuminate\Http\Request;
use App\Models\Attendance;

/**
 * Interface for Data Accessing Object of attendance
 */
interface AttendanceDaoInterface
{
    /**
     * To get attendance lists
     * @return $array of attendances
     */
    public function getAttendances();

    /**
     * To store daily attendance record
     * @return attendance object
     */
    public function saveAttendance(Request $request);

    /**
     * To update daily attendance record
     * @return attendance object
     */
    public function updateAttendance();

    /**
     * To store custom leave record
     * @return collection of $attendances
     */
    public function saveCustomLeave(Request $request);

    /**
     * To get attendance status
     * @return int type of none, checkedin, checkedout
     */
    public function getAttendanceStatus();

    /**
     * To get attendance lists of employee montly
     * @return $array of employees
     */
    public function getMonthlyAttendances();

    /**
     * To delete attendance lists of employee montly
     * @return bool
     */
    public function deleteMonthlyAttendances();
}
