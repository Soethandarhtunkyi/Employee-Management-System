<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Schedule;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('isManager', function ($user) {
            return $user->role_id == config('constants.Manager');
        });

        Gate::define('update-employee', function ($user, $id) {
            return $user->role_id == config('constants.Manager') || $user->id == $id;
        });

        Gate::define('own', function ($user, $id) {
            return $user->id == $id;
        });

        Gate::define('view-tasks', function ($user, Project $project) {
            return $user->id == $project->manager_id ||
                $project->employees->contains($user->id);
        });

        Gate::define('create-task', function ($user, Project $project) {
            return $user->id == $project->manager_id ||
                ($project->employees->contains($user->id) && $user->role_id == config('constants.Senior'));
        });

        Gate::define('view-task', function ($user, Schedule $schedule) {
            return $user->id == $schedule->project->manager_id || $user->id == $schedule->assignor_id
                || $user->id == $schedule->assignee_id;
        });
    }
}
