@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<header>
<h1> <a href="{{ url('/homepage') }}" style="color: black; text-decoration:none; font-size:xxx-large;"> <img
                src="/images/logo.png" style="filter: invert(100%); max-width: 20%; max-height: 20%"> PROJETATU</a></h1>
    <h2>User Profile</h2>
</header>

<body> 
    <div class="BigDivEditProfile" >
        <form  method="POST" action="{{ url('/edit-profile') }}" enctype="multipart/form-data" id="edituserpageForm">
            {{ csrf_field() }}
            <div> Name </div>
            <input type="text" class="edituserpagePlaceholder" value="{{Auth::user()->name}}" id="name" name="name">
           
            
            <div> Email </div>
            <input type="email" class="edituserpagePlaceholder" id="email" value="{{Auth::user()->email}}" name="email">
            
            
            <button type="submit" id="buttonUpdate">Update Profile</button>
            <a href="{{ url('/profile') }}" class="goBackButton" centered> Go back to your profile </a>
        </form>

</body>



@endsection