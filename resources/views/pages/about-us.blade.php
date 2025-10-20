@extends('layouts.app')

@section('title', 'About-Us')

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

<div class="about-us-container">
        <h1>About Us</h1>
        <div class="project-description">
                <p>We are a group of students from the Faculty of Engineering at the University of Porto (FEUP).</p>
                <p>As part of our academic journey, we collaborated on the development of this website in the context of the LBAW class (Laboratory of Databases and Web Applications).</p>
            </div>
        <div class="about-project-container">
            <h1>About the Project</h1>
            <div class="project-description">
                <p>Software tool for tracking and managing projects. This application is designed to help users plan, coordinate, and execute tasks that need to be completed to make progress on the project at hand.</p>

                <p>The primary goal of this project is to provide organizations, teams, or individuals with an intuitive web-based project management solution that optimizes project planning, task allocation, and progress tracking.</p>

                <p>Our motivation behind the development of this project is to simplify and streamline the whole process of project development, and to empower its users and teams to a more efficient and productive work flow by creating a user-friendly platform.</p>
            </div>
        </div>

<footer>
    <div class="rounded-buttons">
        <a href="{{ url('/contact-us') }}" class="rounded-button">Contact Us</a>
        <a href="{{ url('/faq') }}" class="rounded-button">FAQ</a>
        <a href="{{ url('/about-us') }}" class="rounded-button">About Us</a>
    </div>
</footer>
@endsection