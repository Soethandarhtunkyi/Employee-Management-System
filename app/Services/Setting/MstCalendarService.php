<?php

namespace App\Services\Setting;

use App\Contracts\Dao\Setting\MstCalendarDaoInterface;
use App\Contracts\Services\Setting\MstCalendarServiceInterface;

/**
 * Service class for employee
 */
class MstCalendarService implements MstCalendarServiceInterface
{
    /**
     * employee dao
     */
    private $MstCalendarDao;
    /**
     * Class Constructor
     * @param $MstCalendarDaoInterface
     * @return
     */
    public function __construct(MstCalendarDaoInterface $MstCalendarDao)
    {
        $this->MstCalendarDao = $MstCalendarDao;
    }

    /**
     * To upload csv file
     * @return File Upload CSV file
     */
    public function uploadCSV()
    {
        return $this->MstCalendarDao->uploadCSV();
    }
}
