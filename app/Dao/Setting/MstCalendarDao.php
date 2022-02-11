<?php

namespace App\Dao\Setting;


use Maatwebsite\Excel\Facades\Excel;
use App\Contracts\Dao\Setting\MstCalendarDaoInterface;
use App\Imports\MstCalendarsImport;

class MstCalendarDao implements MstCalendarDaoInterface
{
    /**
     * To upload csv file
     * @return File upload csv
     */
    public function uploadCSV()
    {
        return Excel::import(new MstCalendarsImport, request()->file('file'));
    }
}
