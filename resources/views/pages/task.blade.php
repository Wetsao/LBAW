@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<header>
    <h1> <a href="{{ url('/homepage') }}" style="color: black; text-decoration:none; font-size:xxx-large;"> <img
                src="/images/logo.png" style="filter: invert(100%); max-width: 20%; max-height: 20%"> PROJETATU</a></h1>
</header>
<html>

<head>
    <title>Project</title>
</head>


<body>
    <div class="project-list-container">

        <p>
        <h1> Task: {{ $task->name }} </h1>
        </p>
        <p><a>Details:{{$task->details}}</a></p>
        <p><a>Creation:{{$task->creation->format('Y-m-d') }}</a></p>
        <p><a>Delivery:{{$task->delivery->format('Y-m-d') }}</a></p>

        @if ($task->isAssigned($user))
         <form action="{{ route('update.task', ['projectId' => $projects->id, 'taskId' => $task->id]) }}"
            enctype="multipart/form-data" method="POST">
            {{ csrf_field() }}
            
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="Ongoing" {{ $task->status === 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="Paused" {{ $task->status === 'Paused' ? 'selected' : '' }}>Paused</option>
                <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="Abandoned" {{ $task->status === 'Abandoned' ? 'selected' : '' }}>Abandoned</option>
            </select>

            <div>
                <button type="submit">Update Status</button>
            </div>
        </form>
        @endif

    </div>
    <h4>
    @if ($task->creator === auth()->id())
        <input type="hidden" name="task_id" value="{{ $task->id }}">
        <a href="{{ url('/addTaskMember/' . $task->id, ) }}"> Manage Users </a>
    @endif
</h4>

</body>

</html>

@endsection