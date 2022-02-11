<?php

namespace App\Http\Controllers\Attendance;

use App\Contracts\Services\Attendance\AttendanceServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomLeaveRequest;
use App\Http\Requests\StoreAttendanceRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    /**
     * attendance interface
     */
    private $attendanceInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AttendanceServiceInterface $attendanceServiceInterface)
    {
        $this->attendanceInterface = $attendanceServiceInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = $this->attendanceInterface->getAttendances();

        if (!Session::has(Carbon::today()->format('m-d'))) {
            $status = $this->attendanceInterface->getAttendanceStatus();
            Session::put(Carbon::today()->format('m-d'), $status);
        }

        return view('attendances.index')
            ->with(['attendances' => $attendances]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        $result = $this->attendanceInterface->saveAttendance($request);

        $status = $this->attendanceInterface->getAttendanceStatus();
        Session::put(Carbon::today()->format('m-d'), $status);

        if ($result) {
            return redirect()
                ->route('attendances-index')
                ->with('success', 'Your attendance info has been recorded.');
        }

        return back()
            ->withErrors('You have already checked in.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $result = $this->attendanceInterface->updateAttendance();

        $status = $this->attendanceInterface->getAttendanceStatus();
        Session::put(Carbon::today()->format('m-d'), $status);

        if ($result) {
            return redirect()
                ->route('attendances-index')
                ->with('success', 'Your attendance for today has been recorded successfully.');
        }

        return back()
            ->withErrors('You have already checked out or you may have taken leave.');
    }

    /**
     * Create custom leave more than today.
     *
     * @param  \App\Http\Requests\CustomLeaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function customLeave(CustomLeaveRequest $request)
    {
        $leaves = $this->attendanceInterface->saveCustomLeave($request);

        $status = $this->attendanceInterface->getAttendanceStatus();
        Session::put(Carbon::today()->format('m-d'), $status);

        if (count($leaves)) {
            return redirect()
                ->route('attendances-index')
                ->with('success', 'Your leave form has been recorded successfully.');
        }
        
        return back()
            ->withErrors('You already have taken leave for these days.');
    }
}
