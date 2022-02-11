<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'file',
        'status',
        'assignor_id',
        'assignee_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * Get the schedule's status text.
     *
     * @return int
     */
    public function getStatusTextAttribute()
    {
        return $this->status === config('constants.Finished') ?
            'Finished' : ($this->status === config('constants.Progress') ? 'Progress' : 'Not Started');
    }

    /**
     * Get the assignor employee that owns the schedule.
     */
    public function assignor()
    {
        return $this->belongsTo(Employee::class, 'assignor_id');
    }

    /**
     * Get the assignee employee that owns the schedule.
     */
    public function assignee()
    {
        return $this->belongsTo(Employee::class, 'assignee_id');
    }

    /**
     * Get the project that owns the schedule.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
