<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssigned extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'task_assigned';

    protected $fillable = [
        'users_id',
        'task_id',
    ];
}
