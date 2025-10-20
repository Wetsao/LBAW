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
    <style>
        .columns-container {
            display: flex;
        }

        .column-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-right: 20px;
            /* Adjust margin as needed */
            flex: 1;
        }

        .column-box:last-child {
            margin-right: 0;
            /* Remove margin for the last column */
        }

        .task-box {
            border: 1px solid #ddd;
            padding: 8px;
            margin-top: 8px;
        }

        .status-select {
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class='project-list'>
        <p>
        <h1>{{ $projects->name }}</h1>
        </p>
        <p>
            {{ $projects->details }}
        </p>
        @if(!($user->is_admin))
        <div class="columns-container">
            @foreach(['Ongoing', 'Paused', 'Completed', 'Abandoned'] as $status)
            <div class="column-box">
                <h2>{{ $status }}</h2>
                @foreach ($tasks->where('status', $status) as $task)
                <div class="task-box" data-task-id="{{ $task->id }}" data-task-status="{{ $task->status }}">
                    <p>
                        <a href="{{ route('task', ['projectId' => $projects->id, 'taskId' => $task->id]) }}">
                            {{ $task->name }}
                        </a>

                    </p>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
        
        <p>
        </p>
        @if ($projects->isCoordinator($user))
        <a href="{{ route('addTask', ['projectId' => $projects->id]) }}">
            Create Task
        </a> @endif
        @if (!($projects->isCoordinator($user)))
        <a href="{{ url('leave/' .$projects->id) }}">
            Leave Project
        </a> @endif
        @endif
        @if ($projects->isCoordinator($user))
        <a href="{{ url('addCoordinator', ['projectId' => $projects->id]) }}">
            Manage Coordinators
        </a> @endif
    </div>



</body>
<footer>
    <div class="rounded-buttons">
        <a href="{{ url('/contact-us') }}" class="rounded-button">Contact Us</a>
        <a href="{{ url('/faq') }}" class="rounded-button">FAQ</a>
        <a href="{{ url('/about-us') }}" class="rounded-button">About Us</a>
    </div>
</footer>
</html>

@endsection