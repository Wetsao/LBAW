@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<header>
<h1> <a href="{{ url('/homepage') }}" style="color: black; text-decoration:none; font-size:xxx-large;"> <img
                src="/images/logo.png" style="filter: invert(100%); max-width: 20%; max-height: 20%"> PROJETATU</a></h1>    <h2>User Profile</h2>
</header>
<body>
<div type="profile">
    
    <div class="project-list-container">
      <label for="name">Name:</label>
      <span id="name">{{ Auth::user()->name }}</span><br><br>

      <label for="email">Email:</label>
      <span id="email">{{ Auth::user()->email}}</span><br><br>
    </div>
    <a href="{{ url('/edit-profile') }}"><div>Edit Profile</div></a>  
    <p></p>
    <p></p>
    <p></p>

    <a href="{{ url('deleteAccount/'.Auth::user()->id) }}" ><div>Delete Account</div></a>
    </div>

</body>
<footer>
    <div class="rounded-buttons">
        <a href="{{ url('/contact-us') }}" class="rounded-button">Contact Us</a>
        <a href="{{ url('/faq') }}" class="rounded-button">FAQ</a>
        <a href="{{ url('/about-us') }}" class="rounded-button">About Us</a>
    </div>
</footer>


@endsection