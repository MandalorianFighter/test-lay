<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Employee extends Model
{
    use HasFactory, LogsActivity;

    const DET_LIMIT = 100;

    protected $fillable = [
        'employee_name',
        'photo',
        'thumbnail',
        'age',
        'position',
        'department_id',
        'employee_details'
    ];

    protected $with = ['tags', 'department'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->useLogName('employee')
        ->setDescriptionForEvent(fn(string $eventName) => "Employee ({$this->employee_name}) has been {$eventName}.");
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->using(EmployeeTag::class);
    }

    public function limitDetails()
    {
        return Str::limit($this->employee_details, Employee::DET_LIMIT);
    }
}
