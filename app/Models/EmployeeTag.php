<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class EmployeeTag extends Pivot
{
    use LogsActivity;

    public $incrementing = true;

    protected $table = 'employee_tag';
    protected $fillable = ['employee_id', 'tag_id'];
    protected $dates = ['created_at','updated_at'];

    // Activity Log

    public function getActivitylogOptions(): LogOptions
    {
        $employee = Employee::find($this->employee_id);
        return LogOptions::defaults()
        ->logFillable()
        ->useLogName('employee_tag')
        ->setDescriptionForEvent(fn(string $eventName) => "Employee ({$employee->employee_name}) tag has been {$eventName}.");
    }
}