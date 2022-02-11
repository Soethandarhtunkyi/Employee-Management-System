<?php

namespace App\Contracts\Services\Setting;

use App\Models\MstCalender;


/**
 * Interface for Employee service
 */
interface MstCalendarServiceInterface
{
    /**
     * To upload csv file
     * @return File upload csv
     */
    public function uploadCSV();
}
