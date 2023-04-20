<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tag extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'tag_name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->useLogName('tag')
        ->setDescriptionForEvent(fn(string $eventName) => "Tag ({$this->tag_name}) has been {$eventName}.");
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
