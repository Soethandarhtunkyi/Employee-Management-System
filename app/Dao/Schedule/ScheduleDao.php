<?php

namespace App\Dao\Schedule;

use App\Contracts\Dao\Schedule\ScheduleDaoInterface;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

/**
 * Data Access Object for Schedule
 */
class ScheduleDao implements ScheduleDaoInterface
{
    /**
     * To store schedule
     * 
     * @param \App\Models\Project $project
     * @param Illuminate\Http\Request $request
     * @return bool
     */
    public function storeSchedule(Request $request, Project $project)
    {
        try {
            $schedule = false;
            DB::beginTransaction();

            if ($file = $request->file('file')) {
                $schedule = $project->schedules()
                    ->create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'file' => $request->name . time() . '.' . $file->clientExtension(),
                        'status' => config('constants.Not_Started'),
                        'assignor_id' => auth()->id(),
                        'assignee_id' => $request->assignee_id
                    ]);
            }

            DB::commit();
            return $schedule;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To update schedule
     * 
     * @param \App\Models\Schedule $schedule
     * @return bool
     */
    public function updateStatus(Schedule $schedule)
    {
        try {
            DB::beginTransaction();

            $schedule->update([
                'status' => $schedule->status == config('constants.Not_Started') ?
                    config('constants.Progress') :
                    config('constants.Finished')
            ]);

            DB::commit();
            return $schedule;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * To update schedule
     * 
     * @return collection of schedules
     */
    public function getUserSchedules()
    {
        return Schedule::where('status', '<>', config('constants.Finished'))
            ->where(function ($query) {
                $query->where('assignor_id', auth()->id())
                    ->orWhere('assignee_id', auth()->id());
            })
            ->count();
    }
}
