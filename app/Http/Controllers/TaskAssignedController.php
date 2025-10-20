<?php

namespace App\Http\Controllers;

use App\Models\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use App\Models\Task;



class TaskAssignedController extends Controller
{

    public function showAddTaskMember($taskId)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Retrieve the task using the Task model or relevant model, assuming the Task model exists
            $task = Task::findOrFail($taskId); // Change Task to the appropriate model name
            $project = $task->project;
            $allUsers = User::all();

            // Get the list of users already added to the task
            $usersInTask = $task->users()->pluck('users.id')->toArray();
            $usersInProject = $project->users()->pluck('users.id')->toArray();
            $usersInProject = $project->users;

            return view('pages.addTaskMember', [
                'task' => $task, // Pass the $task variable to the view
                'allUsers' => $allUsers,
                'usersInTask' => $usersInTask,
                'usersInProject' => $usersInProject, // Pass this information to the view
            ]);
        }
    }

    public function insert(Request $request)
    {

        $task_assigned = new TaskAssigned();
        $task_assigned->users_id = $request->user_id;
        $task_assigned->task_id = $request->task_id;
        $task_assigned->save();
        
        return response()->json(['message' => 'User added to the Task']);
    }

    public function removeUser(Request $request)
    {
        $task_id = $request->task_id;
        $user_id = $request->user_id;

        TaskAssigned::where('task_id', $task_id)
            ->where('users_id', $user_id)
            ->delete();

        return response()->json(['message' => 'User removed from the Task']);
    }


}
