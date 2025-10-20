<?php

namespace App\Http\Controllers;

use App\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;


class ProjectMemberController extends Controller
{

    public function showAddProjectMember($projectId)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $allUsers = User::all();
            $project = Project::findOrFail($projectId);

            $usersInProject = $project->users()->pluck('users.id')->toArray();
            $this->authorize('view', $user);
            if($project->isCoordinator($user)){
                return view('pages.addProjectMember', [
                    'projects' => $project,
                    'allUsers' => $allUsers,
                    'usersInProject' => $usersInProject,
                ]);
            }
            else if(!($project->isCoordinator($user))){
                return redirect('/homepage');
            }
        }
    }

    public function insert(Request $request)
    {
        $project_member = new ProjectMember();
        $project_member->users_id = $request->user_id; 
        $project_member->project_id = $request->project_id; 
        $project_member->save();

        return response()->json(['message' => 'User added to the project']);
    }

    public function updateFavorite(Request $request, Project $project) {
        $user = Auth::user();
    
        $projectMember = ProjectMember::where('project_id', $project->id)
            ->where('users_id', $user->id)
            ->first();
    
        if ($projectMember) {
            $projectMember->is_favorite = !$projectMember->is_favorite;
            $projectMember->save();
            $this->authorize('update', $projectMember);
            return redirect()->back()->with('success', 'Project favorite status updated');

    }
}

    public function removeUser(Request $request)
    {
        $project_id = $request->project_id;
        $user_id = $request->user_id;

        ProjectMember::where('project_id', $project_id)
            ->where('users_id', $user_id) // Change 'user_id' to 'users_id'
            ->delete();

        return response()->json(['message' => 'User removed from the project']);
    }




}
