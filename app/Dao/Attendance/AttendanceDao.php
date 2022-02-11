<?php

namespace App\Dao\Attendance;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Contracts\Dao\Attendance\AttendanceDaoInterface;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for attendance
 */
class AttendanceDao implements AttendanceDaoInterface
{
    /**
     * To get attendance lists
     * @return $array of attendances
     */
    public function getAttendances()
    {
        $authUser = Attendance::whereDate('created_at', Carbon::today())
            ->where('employee_id', auth()->id())
            ->with('employee.role', 'employee.department', 'employee')
            ->get();

        $sortedAttendances = Attendance::whereDate('created_at', Carbon::today())
            ->where('employee_id', '<>', auth()->id())
            ->with('employee.role', 'employee.department', 'employee')
            ->latest()
            ->get();

        return $authUser->concat($sortedAttendances);
    }

    /**
     * To store daily attendance record
     * @return attendance object
     */
    public function saveAttendance(Request $request)
    {
        $attendance = auth()->user()
            ->attendances()
            ->whereDate('created_at', Carbon::today())
            ->first();

        // Check attendance already exist
        if ($attendance) {
            return false;
        } else {
            $attendance = DB::transaction(function () use ($request) {
                return auth()->user()
                    ->attendances()
                    ->create($request->all());
            }, 5);
            return $attendance;
        }
    }

    /**
     * To update daily attendance record
     * @return attendance object
     */
    public function updateAttendance()
    {
        $attendance = auth()->user()
            ->attendances()
            ->whereDate('created_at', Carbon::today())
            ->where('leave', 0)
            ->whereNull('working_hours')
            ->first();

        if ($attendance) {
            DB::transaction(function () use ($attendance) {
                $workingHours = now()->diffInMinutes($attendance->created_at);
                $workingHours = round($workingHours / 60, 1) - 1;
                $attendance->working_hours = $workingHours;
                if ($workingHours > config('constants.Actual_Working_Hours')) {
                    $overtime = round($workingHours - config('constants.Actual_Working_Hours'), 1);
                    $attendance->overtime = $overtime;
                }
                $attendance->save();
            }, 5);
            return $attendance;
        } else {
            return false;
        }
    }

    /**
     * To store custom leave record
     * @return collection of $attendances
     */
    public function saveCustomLeave(Request $request)
    {
        $start = Carbon::parse($request->start_date)->format('Y-m-d H:i:s');
        $end = Carbon::parse($request->end_date)->format('Y-m-d H:i:s');
        $period = CarbonPeriod::create($start, $end);
        $attendances = [];

        try {
            DB::beginTransaction();

            foreach ($period as $date) {
                $attendance = auth()->user()
                    ->attendances()
                    ->whereDate('created_at', $date)
                    ->first();
                if (
                    $date->format('l') != config('constants.Sat') &&
                    $date->format('l') != config('constants.Sun') &&
                    !$attendance
                ) {
                    $attendances[] = auth()->user()
                        ->attendances()
                        ->create([
                            'leave' => 1,
                            'created_at' => $date
                        ]);
                }
            }

            DB::commit();
            return $attendances;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To get attendance status
     * @return int type of none, checkedin, checkedout
     */
    public function getAttendanceStatus()
    {
        $status = config('constants.None');

        $checkedin = auth()->user()
            ->attendances()
            ->whereDate('created_at', Carbon::today())
            ->where('leave', config('constants.Non-leave'))
            ->whereNull('working_hours')
            ->first();

        $checkedout =  auth()->user()
            ->attendances()
            ->whereDate('created_at', Carbon::today())
            ->where(function ($query) {
                $query->whereNotNull('working_hours')
                    ->orWhere('leave', config('constants.Leave'));
            })
            ->first();

        if ($checkedin) {
            $status = config('constants.Checkedin');
        }

        if ($checkedout) {
            $status = config('constants.Checkedout');
        }

        return $status;
    }

    /**
     * To get attendance lists of employee montly
     * @return $array of employees
     */
    public function getMonthlyAttendances()
    {
        return Employee::with('role', 'department')
            ->get();
    }

    /**
     * To delete attendance lists of employee montly
     * @return bool
     */
    public function deleteMonthlyAttendances()
    {
        try {
            DB::beginTransaction();

            Attendance::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
