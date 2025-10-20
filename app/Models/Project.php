<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;


class Project extends Model
{   

    public $timestamps = false;
    protected $casts = [
        'delivery' => 'datetime', // Cast the delivery field to a datetime
    ];
    protected $table = 'project'; 
    protected $fillable = [
        'name',
        'details',
        'delivery',
    ];



    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_member', 'project_id', 'users_id');
    }

    public function coordinators()
    {
        return $this->belongsToMany(User::class, 'project_coordinator', 'project_id', 'users_id');
    }

    public function isCoordinator($user)
    {
        // Assuming $user is the current authenticated user
        return $this->coordinators->contains($user);
    }

    public function index(){
    $allProjects = Project::all();
    return view('homepage', [
        'allProjects' => $allProjects,
        // Other variables you might be passing
    ]);
    }    

    public function isFavorite()
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $this->members()
                    ->where('users_id', $user->id)
                    ->where('is_favorite', true)
                    ->exists();
    }

    public function members()
    {
        return $this->hasMany(ProjectMember::class);
    }



}