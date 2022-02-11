<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'working_hours',
        'leave',
        'type',
        'overtime',
        'created_at'
    ];

    /**
     * Get the employee that owns the attendance.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the attendance's type name.
     *
     * @return string
     */
    public function getTypeNameAttribute()
    {
        if ($this->type === config('constants.WFH')) {
            return 'WFH';
        } elseif ($this->type === config('constants.Office')) {
            return 'Office';
        } else {
            return '-';
        }
    }

    /**
     * Get the employee's attendance status.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        $attendance = $this->leave === 0;
        return $attendance ? 'Present' : 'Absent';
    }
}
