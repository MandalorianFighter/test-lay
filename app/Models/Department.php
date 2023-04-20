<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Department extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'department_name',
        'department_details',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->useLogName('department')
        ->setDescriptionForEvent(fn(string $eventName) => "Department ({$this->department_name}) has been {$eventName}.");
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
