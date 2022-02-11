<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\ImportMstCalendarsRequest;

use App\Contracts\Services\Setting\MstCalendarServiceInterface;

class MstCalendarController extends Controller
{
    /**
     * task interface
     */
    private $MstCalendarInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MstCalendarServiceInterface $MstCalendarServiceInterface)
    {
        $this->MstCalendarInterface = $MstCalendarServiceInterface;
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

        return view('setting.mstcalendarupload');
    }

    /**
     * Import the csv file
     * 
     * @param \App\Http\Requests\ImportMstCalendarsRequest $request 
     * @return \Illuminate\Http\Response
     */
    public function submitUpload(ImportMstCalendarsRequest $request)
    {
        // Check user has manager access or not.
        if (Gate::denies('isManager')) {
            abort(401);
        }

        if ($this->MstCalendarInterface->uploadCSV()) {
            return redirect()
                ->route('calendar-upload')
                ->with('success', 'Successfully Imported CSV File.');
        }
    }
}
