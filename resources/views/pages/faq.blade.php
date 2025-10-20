@extends('layouts.app')

@section('title', 'FAQ')

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


<div class="faq-container">
        <h1>Frequently Asked Questions</h1>

        <div class="faq-item">
            <h2>What is PROJETATU?</h2>
            <p>PROJETATU is a project management platform designed to help users collaborate, organize tasks, and streamline project workflows.</p>
        </div>

        <div class="faq-item">
            <h2>How do I create a new project?</h2>
            <p>To create a new project, navigate to your dashboard, click on the "Create Project" button, and fill in the required project details such as name, description, and team members.</p>
        </div>

        <div class="faq-item">
            <h2>Can I invite team members to join my project?</h2>
            <p>Yes, if you are a project coordinator there will be an option "Manage Users" in the projects main page, that will lead to a page where you can add other users to the project</p>
        </div>

        <div class="faq-item">
            <h2>How do I update task status?</h2>
            <p>To update the status of a task, go to the project board, find the task and click on it. Then there will be an option for the status and an update button. You can choose from options like "Ongoing", "Paused", "Completed" and "Abandoned" </p>
        </div>

        <div class="faq-item">
            <h2>Is PROJETATU mobile-friendly?</h2>
            <p>PROJETATU wasn't made with mobile in mind so as a result it wasn't tested there.</p>
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