<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Models\ProjectCoordinator;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;

class ProjectCoordinatorController extends Controller
{
    public function showProjectCoordinator($projectId){
        if (Auth::check()) {
            $user = Auth::user();

            $project = Project::findOrFail($projectId);

            $usersInProject = $project->users()->get();
            $usersCoordinators = $project->coordinators()->pluck('users.id')->toArray();
            // $this->authorize('view', $user);
            if($project->isCoordinator($user)){
                return view('pages.addProjectCoordinator', [
                    'projects' => $project,
                    'usersInProject' => $usersInProject,
                    'usersCoordinators' => $usersCoordinators, 
                ]);
            }
            else if(!($project->isCoordinator($user))){
                return redirect('/homepage');
            }
            
        }
    }
    public function insertCoordinator(Request $request)
    {
        $project_coordinator = new ProjectCoordinator();
        $project_coordinator->users_id = $request->user_id; 
        $project_coordinator->project_id = $request->project_id; 
        $project_coordinator->save();

        return response()->json(['message' => 'User added as Coordinator']);
    }

    public function removeCoordinator(Request $request)
    {
        $project_id = $request->project_id;
        $user_id = $request->user_id;

        ProjectCoordinator::where('project_id', $project_id)
            ->where('users_id', $user_id) // Change 'user_id' to 'users_id'
            ->delete();

        return response()->json(['message' => 'User removed as Coordinator']);
    }
}
