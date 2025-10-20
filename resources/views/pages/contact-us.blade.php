@extends('layouts.app')

@section('title', 'Services')

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

<div class="contact-us-container">
        <h1>Contact Us</h1>
        <p>If you have any questions, feedback, or concerns, feel free to get in touch with our dedicated team of developers.</p>

        <div class="developer">
            <div class="developer-info">
                <h2>Alexandre Morais</h2>
                <p class="role">Lead Developer</p>
                <p class="contact-info">Email: <a href="mailto:up201906049@fc.up.pt">up201906049@fc.up.pt</a></p>
            </div>
        </div>

        <div class="developer">
            <div class="developer-info">
                <h2>Bruno Leal</h2>
                <p class="role">Lead Developer</p>
                <p class="contact-info">Email: <a href="mailto:up202008047@fe.up.pt">up202008047@fe.up.pt</a></p>
            </div>
        </div>

        <div class="developer">
            <div class="developer-info">
                <h2>Nuno Ramos</h2>
                <p class="role">Lead Developer</p>
                <p class="contact-info">Email: <a href="mailto:up201906051@fc.up.pt">up201906051@fc.up.pt</a></p>
            </div>
        </div>

        <!-- Add more developer sections as needed -->

        <h2>Contact Form</h2>
        <!-- Add your stylish contact form here -->

        <p class="response-time">We aim to respond to your inquiries within 24 hours. Thank you for reaching out!</p>
    </div>

<footer>
    <div class="rounded-buttons">
        <a href="{{ url('/contact-us') }}" class="rounded-button">Contact Us</a>
        <a href="{{ url('/faq') }}" class="rounded-button">FAQ</a>
        <a href="{{ url('/about-us') }}" class="rounded-button">About Us</a>
    </div>
</footer>
@endsection