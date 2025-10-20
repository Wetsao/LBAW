<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCoordinator extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'project_coordinator';

    protected $fillable = [
        'users_id',
        'project_id',
    ];

}
