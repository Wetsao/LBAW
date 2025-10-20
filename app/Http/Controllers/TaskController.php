<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showCreate($projectId)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $project = Project::findOrFail($projectId); // Retrieve the project
            return view('pages.addTask', ['user' => $user, 'projects' => $project]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $projectId)
    {
        if (Auth::check()) {

            $user = Auth::user();

            $tasks = new Task();
            $tasks->project_id = $projectId;
            $tasks->creator = $user->id;
            $tasks->name = $request->input('name');
            $tasks->details = $request->input('details');
            $tasks->delivery = $request->input('delivery');

            $tasks->save();

            return redirect()->route('project-page', ['projectId' => $projectId])->with('status', 'Inserted Successfully!');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showTask($taskId, $projectId)
    {
        if (Auth::check()) {

            $user = Auth::user();


            if ($user->is_admin) {
                $task = Task::findOrFail($projectId);
                $projects = $user->projects()->findOrFail($taskId);

                $tasks = $projects->tasks;
                return view('pages.task', ['user' => $user, 'task' => $task, 'projects' => $projects,]);

            }

            $task = Task::findOrFail($projectId);
            $projects = $user->projects()->findOrFail($taskId);




            return view('pages.task', ['user' => $user, 'task' => $task, 'projects' => $projects]);
        }

    }
    public function update(Request $request, $taskId, $projectId)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $task = Task::findOrFail($taskId);
            $projects = $user->projects()->findOrFail($projectId);
            if ($request->has('status') && $request->input('status') !== null) {
                $task->status = $request->input('status');
                $task->save();
            }

            return redirect()->route('project-page', ['projectId' => $projectId, 'taskId' => $taskId]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
