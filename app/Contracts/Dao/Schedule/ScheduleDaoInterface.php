<?php

namespace App\Contracts\Dao\Schedule;

use App\Models\Project;
use App\Models\Schedule;
use Illuminate\Http\Request;

/**
 * Interface for Data Accessing Object of Schedule
 */
interface ScheduleDaoInterface
{
    /**
     * To store schedule
     * 
     * @param \App\Models\Project $project
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function storeSchedule(Request $request, Project $project);

    /**
     * To update schedule
     * 
     * @param \App\Models\Schedule $schedule
     * @return bool
     */
    public function updateStatus(Schedule $schedule);

    /**
     * To update schedule
     * 
     * @return collection of schedules
     */
    public function getUserSchedules();
}
