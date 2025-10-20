@extends('layouts.app')

@section('title', 'addProjectCoordinator')

@section('content')

<header>
    <h1> <a href="{{ url('/homepage') }}" style="color: black; text-decoration:none; font-size:xxx-large;"> <img
                src="/images/logo.png" style="filter: invert(100%); max-width: 20%; max-height: 20%"> PROJETATU</a></h1>
    <h4>Add Coordinators to: {{$projects->name}}</h4>
    <h4><button onclick="refreshPage()">Apply Changes</button></h4>

    <script>
        function refreshPage() {
            location.reload();
        }
    </script>

</header>

<body>

    <div class="project-list">
        <div class="project-list-container">

            <thead>
                <tr>
                </tr>
            </thead>
            <tbody>
                @foreach ($usersInProject as $user)
                @if(!($user->is_admin))
                <tr>
                    <h5>{{ $user->name }}  </h5>

                    |

                    @if (in_array($user->id, $usersCoordinators))
                    &#x2705;
                    <form method="POST" action="{{ route('removeCoordinator') }}" class="removeUserForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="project_id" value="{{ $projects->id }}">
                        <button type="submit">Remove</button>
                    </form>
                    @else
                    <form method="POST" action="{{url('insertCoordinator')}}" class="addUserForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="project_id" value="{{ $projects->id }}">
                        <button type="submit">Add</button>
                    </form>
                    @endif
                </tr>
                @endif
                @endforeach

                <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
                <script>
                    // Add click event listeners for both Add and Remove forms
                    document.querySelectorAll('.addUserForm, .removeUserForm').forEach(form => {
                        form.addEventListener('submit', function (event) {
                            event.preventDefault();

                            const formData = new FormData(form);

                            axios.post(form.action, formData)
                                .then(response => {
                                    // Handle the response if needed
                                    console.log(response.data);
                                    // Optionally update the page content without reloading
                                })
                                .catch(error => {
                                    // Handle errors if any
                                    console.error(error);
                                });
                        });
                    });

                </script>

                

            </tbody>

        </div>
    </div>


</body>



@endsection