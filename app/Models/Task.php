<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;

    protected $casts = [
        'delivery' => 'datetime',
        'creation' => 'datetime', // Cast the delivery field to a datetime
    ];
    protected $table = 'task';


    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assigned()
    {
        return $this->belongsToMany(User::class, 'task_assigned', 'task_id', 'users_id');
    }
    
    public function isAssigned($user)
    {
        return $this->assigned->contains($user);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator'); // Assuming 'creator' is the foreign key in the tasks table
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_assigned', 'task_id', 'users_id');
    }
}