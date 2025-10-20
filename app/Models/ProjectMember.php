<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'project_member';

    protected $fillable = [
        'users_id',
        'project_id',
    ];


    
}
