<?php

namespace App\Models;

use App\Models\Attendance;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'profile',
        'role_id',
        'department_id',
        'created_user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the role that owns the employee.
     */
    public function role()
    {
        return $this->belongsTo(MstRole::class);
    }

    /**
     * Get the department that owns the employee.
     */
    public function department()
    {
        return $this->belongsTo(MstDepartment::class);
    }

    /**
     * Get the salary associated with the employee.
     */
    public function salary()
    {
        return $this->hasOne(Salary::class);
    }

    /**
     * Get the final salaries for the employee.
     */
    public function finalsalaries()
    {
        return $this->hasMany(FinalSalary::class);
    }

    /**
     * Get the attendance for the employee.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * The projects that belong to the employee.
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTimeStamps();
    }

    /**
     * Get the employee's total working days.
     *
     * @return int
     */
    public function getWorkingDaysAttribute()
    {
        $count = Attendance::where('employee_id', $this->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('leave', 0)
            ->count();
        return $count;
    }

    /**
     * Get the employee's total leave days.
     *
     * @return int
     */
    public function getLeaveDaysAttribute()
    {
        $count = Attendance::where('employee_id', $this->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('leave', 1)
            ->count();
        return $count;
    }

    /**
     * Get the employee's total overtimes.
     *
     * @return int
     */
    public function getOvertimesAttribute()
    {
        $sum = Attendance::where('employee_id', $this->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereNotNull('overtime')
            ->sum('overtime');
        return $sum;
    }

    /**
     * Get the employee's joined date format.
     *
     * @return int
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format(config('constants.Date_Format'));   
    }


    /**  
     * Ondelete cascade for employee
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($employee) {
            $employee->salary()->delete();
            $employee->finalsalaries()->delete();
            $employee->attendances()->delete();
            $employee->projects()->detach();
        });
    }
}
