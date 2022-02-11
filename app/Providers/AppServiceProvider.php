<?php

namespace App\Providers;

use App\Models\FinalSalary;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Dao Registration
        $this->app->bind('App\Contracts\Dao\Employee\EmployeeDaoInterface', 'App\Dao\Employee\EmployeeDao');
        $this->app->bind('App\Contracts\Dao\Attendance\AttendanceDaoInterface', 'App\Dao\Attendance\AttendanceDao');
        $this->app->bind('App\Contracts\Dao\Auth\AuthDaoInterface', 'App\Dao\Auth\AuthDao');
        $this->app->bind('App\Contracts\Dao\Payroll\PayrollDaoInterface', 'App\Dao\Payroll\PayrollDao');
        $this->app->bind('App\Contracts\Dao\Project\ProjectDaoInterface', 'App\Dao\Project\ProjectDao');
        $this->app->bind('App\Contracts\Dao\Schedule\ScheduleDaoInterface', 'App\Dao\Schedule\ScheduleDao');
        $this->app->bind('App\Contracts\Dao\Setting\MstCalendarDaoInterface', 'App\Dao\Setting\MstCalendarDao');

        // Business logic registration
        $this->app->bind('App\Contracts\Services\Employee\EmployeeServiceInterface', 'App\Services\Employee\EmployeeService');
        $this->app->bind('App\Contracts\Services\Attendance\AttendanceServiceInterface', 'App\Services\Attendance\AttendanceService');
        $this->app->bind('App\Contracts\Services\Auth\AuthServiceInterface', 'App\Services\Auth\AuthService');
        $this->app->bind('App\Contracts\Services\Auth\ForgetPasswordInterface', 'App\Services\Auth\ForgetPasswordService');
        $this->app->bind('App\Contracts\Services\Payroll\PayrollServiceInterface', 'App\Services\Payroll\PayrollService');
        $this->app->bind('App\Contracts\Services\Project\ProjectServiceInterface', 'App\Services\Project\ProjectService');
        $this->app->bind('App\Contracts\Services\Schedule\ScheduleServiceInterface', 'App\Services\Schedule\ScheduleService');
        $this->app->bind('App\Contracts\Services\Setting\MstCalendarServiceInterface', 'App\Services\Setting\MstCalendarService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Blade::if('oldcalculation', function (FinalSalary $finalSalary) {
            if (Carbon::parse($finalSalary->updated_at)->format('m-d') == Carbon::today()->format('m-d')) {
                return false;
            }
            return true;
        });
    }
}
