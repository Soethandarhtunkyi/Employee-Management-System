<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalSalary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year',
        'month',
        'total_leave_days',
        'total_leave_fines',
        'total_overtimes',
        'total_overtime_fees',
        'total_working_hours',
        'salary',
        'file'
    ];
    
    /**
     * Get the employee that owns the final salary.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
