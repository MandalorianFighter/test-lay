<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;

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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function limitDetails()
    {
        return Str::limit($this->employee_details, Employee::DET_LIMIT);
    }
}
