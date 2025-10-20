<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\ProjectMember;

class ProjectPageController extends Controller
{
    /*public function showProject($projectId)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $projects = $user->projects()->wherePivot('project_id', $projectId)->get();
            $tasks = $user->projects()->wherePivot('project_id', $projectId)->tasks;
            #$assignedtasks = $user->assignedTasks()->wherePivot('project_id', $projectId)->get();
            return view('pages.project-page',['user' => $user], ['projects' => $projects,],['tasks' =>$tasks]);
        }
    }*/
    public function showProject($projectId)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $projectMember = $user;

            if($user->is_admin){
                $projects = $project = Project::find($projectId);;
                
                $tasks = $projects->tasks;

                 return view('pages.project-page', [
                'user' => $user,
                'projects' => $projects,
                'tasks' => $tasks,
            ]);
            }
            
            $projects = $user->projects()->findOrFail($projectId);

            $tasks = $projects->tasks;
            $this->authorize('view', $projectMember);
            return view('pages.project-page', [
                'user' => $user,
                'projects' => $projects,
                'tasks' => $tasks,
            ]);
        }
    }
    public function leave($projectId)
    {
        if(Auth::user()){
            $user = Auth::user();
            $projectMember = ProjectMember::where('users_id', '=', $user->id)->where('project_id','=', $projectId);
            $projectMember->delete();
            return redirect('/homepage')->with('status','Left Project Sucessfully!');
        }
    }
}
