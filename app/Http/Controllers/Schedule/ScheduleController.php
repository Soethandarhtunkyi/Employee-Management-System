<?php

namespace App\Http\Controllers\Schedule;

use App\Contracts\Services\Schedule\ScheduleServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    /**
     * schedule service interface
     */
    private $scheduleInterface;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ScheduleServiceInterface $scheduleServiceInterface)
    {
        $this->scheduleInterface = $scheduleServiceInterface;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function scheduleCreateView(Project $project)
    {
        // Check user is project manager or senior.
        if (Gate::denies('create-task', $project)) {
            abort(401);
        }

        return view('schedules.create')
            ->with(['project' => $project]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Project $project
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSchedule(Request $request, Project $project)
    {
        // Check user is project manager or senior.
        if (Gate::denies('create-task', $project)) {
            abort(401);
        }

        $schedule = $this->scheduleInterface->storeSchedule($request, $project);

        if ($schedule) {
            return redirect()
                ->route('projects-showDetail', [$project->id])
                ->with('success', 'Schdule Created Successfully.');
        }

        return back()
            ->withErrors('Unknown error occured.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function showSchedule(Schedule $schedule)
    {
        // Check user is project manager or employee that associated to schedule.
        if (Gate::denies('view-task', $schedule)) {
            abort(401);
        }

        $schedule->load('assignor', 'assignee');

        return view('schedules.show')
            ->with(['schedule' => $schedule]);
    }

    /**
     * Download the file to the employee.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Schedule $schedule)
    {
        // Check user is project manager or employee that associated to schedule.
        if (Gate::denies('view-task', $schedule)) {
            abort(401);
        }

        return Storage::download(config('path.schedule_path') . $schedule->project->name . config('path.separator') . $schedule->file);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Schedule $schedule)
    {
        // Check user is project manager or employee that associated to schedule.
        if (Gate::denies('view-task', $schedule)) {
            abort(401);
        }

        $result = $this->scheduleInterface->updateStatus($schedule);

        if ($result) {
            return back()
                ->with('success', 'Schdule Marked as ' . $result->status_text . ' Successfully.');
        }

        return back()
            ->withErrors('Unknown error occured.');
    }
}
