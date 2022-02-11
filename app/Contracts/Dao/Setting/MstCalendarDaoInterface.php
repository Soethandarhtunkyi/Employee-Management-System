<?php

namespace App\Contracts\Dao\Setting;

use Illuminate\Http\Request;
use App\Models\MstCalender;


/**
 * Interface for Data Accessing Object of employee
 */
interface MstCalendarDaoInterface
{
    /**
     * To upload csv file
     * @return File upload csv
     */
    public function uploadCSV();
}
