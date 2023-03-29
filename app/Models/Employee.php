<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_name',
        'photo',
        'age',
        'position',
        'department_id',
        'employee_details'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
