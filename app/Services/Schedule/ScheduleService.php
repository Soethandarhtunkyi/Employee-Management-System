<?php

namespace App\Services\Schedule;

use App\Contracts\Dao\Schedule\ScheduleDaoInterface;
use App\Contracts\Services\Schedule\ScheduleServiceInterface;
use App\Jobs\SendTaskNotiJob;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use Mail;

/**
 * Service class for Project
 */
class ScheduleService implements ScheduleServiceInterface
{
    /**
     * Schedule dao
     */
    private $scheduleDao;
    /**
     * Class Constructor
     * @param payrollDaoInterface
     * @return
     */
    public function __construct(ScheduleDaoInterface $scheduleDao)
    {
        $this->scheduleDao = $scheduleDao;
    }

    /**
     * To store schedule
     * 
     * @param App\Models\Project $project
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function storeSchedule(Request $request, Project $project)
    {
        $schedule = $this->scheduleDao->storeSchedule($request, $project);

        if ($schedule) {
            $request->file('file')
                ->storeAs(config('path.schedule_path') . $project->name, $schedule->file);
            dispatch(new SendTaskNotiJob($schedule));
            if (count(Mail::failures()) > 0) {
                Log::error('Mail Sending Error', Mail::failures());
            }
        }

        return $schedule;
    }

    /**
     * To update schedule
     * 
     * @param \App\Models\Schedule $schedule
     * @return bool
     */
    public function updateStatus(Schedule $schedule)
    {
        return $this->scheduleDao->updateStatus($schedule);
    }

    /**
     * To update schedule
     * 
     * @return collection of schedules
     */
    public function getUserSchedules()
    {
        return $this->scheduleDao->getUserSchedules();
    }
}
