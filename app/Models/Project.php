<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'project_title',
        'project_description',
        'project_status',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}