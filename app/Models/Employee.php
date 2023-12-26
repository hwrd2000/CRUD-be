<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'department_id',
        'photo',
    ];

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
