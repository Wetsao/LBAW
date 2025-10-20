@extends('layouts.app')

@section('title', 'Homepage')

@section('content')
<header>
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <div class="profile-btn">
        <a href="{{ url('/profile') }}">
            <div>Profile</div>
        </a>
    </div>
    <h1> <a href="{{ url('/homepage') }}" style="color: black; text-decoration:none; font-size:xxx-large;"> <img
                src="/images/logo.png" style="filter: invert(100%); max-width: 20%; max-height: 20%"> PROJETATU</a></h1>

</header>

<body>
    @if (!($user->is_admin))

    <h1> <a href="{{ url('add') }}"> Create Project</a> </h1>
    <div class="project-list">
        <div class="project-list-container">
            @if($user->projects->isNotEmpty())
            <h1>My Projects</h1>
            <h3>Favourite Projects:</h3>
            @foreach ($favoriteProjects as $project)
            <p>
            <form action="{{ route('updateFavorite', ['project' => $project->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="fav" type="submit">
                &#8595
                </button>
            </form>
            
            <a href="{{ url('/project-page/' . $project->id) }}">{{ $project->name }} | Deadline: {{
                $project->delivery->format('Y-m-d') }}</a> |
            @if ($project->isCoordinator($user))

            <a href="{{ url('/addProjectMember/' . $project->id) }}"> Manage Users </a>
            |
            @endif

            <a href="" data-toggle="modal" data-target="#exampleModalCenter_{{ $project->id }}">
                Members List
            </a>
            |
            @if ($project->isCoordinator($user))

            <a href="{{ url('delete/'.$project->id) }}" class="btn-delete"> Delete Project</a>
            |
            @endif


            <div class="modal fade modal-dialog-scrollable" id="exampleModalCenter_{{ $project->id }}" tabindex="-1"
                role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Project Member List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach ($project->users as $user)

                            <h4>{{ $user->name }}</h4>
                            <p></p>

                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <h3>Other Projects:</h3>
            @foreach ($otherProjects as $project)
            <p>
            <form action="{{ route('updateFavorite', ['project' => $project->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="fav" type="submit">
                &#8593
                </button>
            </form>
            <a href="{{ url('/project-page/' . $project->id) }}">{{ $project->name }} | Deadline: {{
                $project->delivery->format('Y-m-d') }}</a> |
            @if ($project->isCoordinator($user))

            <a href="{{ url('/addProjectMember/' . $project->id) }}"> Manage Users </a>
            |
            @endif

            <a href="" data-toggle="modal" data-target="#exampleModalCenter_{{ $project->id }}">
                Members List
            </a>
            |
            @if ($project->isCoordinator($user))

            <a href="{{ url('delete/'.$project->id) }}" class="btn-delete"> Delete Project</a>
            |
            @endif
            <div class="modal fade modal-dialog-scrollable" id="exampleModalCenter1_{{ $project->id }}" tabindex="-1"
                role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Project Member List</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach ($project->users as $user)

                            <h4>{{ $user->name }}</h4>
                            <p></p>

                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            </p>
            @endforeach
            @else
            <p>No projects found for this user.</p>
            @endif
        </div>





    </div>
    @endif

    @if($user->is_admin)
    <div class="project-list">
        <div class="project-list-container">
            <h1>User List</h1>

            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                @foreach ($allUsers as $user)
                <h1>
                    <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#exampleModalCenter_{{ $user->id }}">
                        {{ $user->name ?? 'user-deleted' }}
                    </button>

                </h1>
                <p>
                </p>

                <!-- Modal -->
                <div class="modal fade modal-dialog-scrollable" id="exampleModalCenter_{{ $user->id }}" tabindex="-1"
                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ID: {{ $user->id }}
                                <p></p>
                                NAME: {{ $user->name ?? 'user-deleted' }}
                                <p></p>
                                EMAIL: {{ $user->email ?? 'user-deleted' }}
                                <p></p>
                                @if($user->is_admin)
                                ADMIN: YES
                                @else
                                ADMIN: NO
                                @endif

                            </div>
                            <div class="modal-footer">
                                
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="{{ url('deleteAccount/'.$user->id ) }}" type="button"
                                    class="btn btn-primary">Delete Account</a>
                            </div>
                        </div>
                    </div>
                </div>


                @endforeach
            </tbody>

        </div>
    </div>
    @endif

</body>

@if ($user->is_admin)

<body>
    <div class="container">
        <h3 align="center">Project Search</h3><br />
        <div class="row">
            <h2>Search: <span id="total_records"></span></h2>
            <div class="col-12">
                <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search Project" />
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url: "{{ route('action') }}",
                    method: 'GET',
                    data: { query: query },
                    dataType: 'json',
                    success: function (data) {
                        $('tbody').html(data.table_data);
                        $('#total_records').text(data.total_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
    </script>
    <div class="project-list">
        <div class="project-list-container">
            <h3>All Projects:</h3>
            @foreach ($allProjects as $project)
            <a href="{{ url('/project-page/' . $project->id) }}">
                {{ $project->name }} | Deadline: {{ $project->delivery->format('Y-m-d') }}
            </a>
            <p></p>
            @endforeach
        </div>
    </div>
</body>
@endif
<footer>
    <div class="rounded-buttons">
        <a href="{{ url('/contact-us') }}" class="rounded-button">Contact Us</a>
        <a href="{{ url('/faq') }}" class="rounded-button">FAQ</a>
        <a href="{{ url('/about-us') }}" class="rounded-button">About Us</a>
    </div>
</footer>
@endsection