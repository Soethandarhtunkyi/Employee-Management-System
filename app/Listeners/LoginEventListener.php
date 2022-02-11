<?php

namespace App\Listeners;

use App\Contracts\Services\Schedule\ScheduleServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class LoginEventListener
{
    /**
     * schedule service interface
     */
    private $scheduleInterface;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ScheduleServiceInterface $scheduleServiceInterface)
    {
        $this->scheduleInterface = $scheduleServiceInterface;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $count = $this->scheduleInterface->getUserSchedules();

        if ($count > 0) {
            Session::flash('task', 'There are ' . $count . ' unfinished tasks that you are involved.');
        }
    }
}
