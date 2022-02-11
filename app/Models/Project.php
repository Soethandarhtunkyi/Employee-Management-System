<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'link',
        'manager_id'
    ];

    /**
     * The employees that belong to the project.
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withTimeStamps();
    }

    /**
     * Get the schedules for the project.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the manager that owns the project.
     */
    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Get the project's pending tasks.
     *
     * @return int
     */
    public function getPendingTasksAttribute()
    {
        $count = $this->schedules()
            ->where('status', '<>', config('constants.Finished'))
            ->count();
        return $count;
    }

    /**  
     * Ondelete cascade for employee
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($project) {
            $project->schedules()->delete();
            $project->employees()->detach();
        });
    }
}
