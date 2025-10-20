@extends('layouts.app')
@section('content')



<form method="POST" action="{{ url('/forgot-password') }}">
    {{ csrf_field() }}
    <h1><img style="filter: invert(100%);" src="/images/logo.png" > <a style="color: black; text-decoration:none; font-size:xxx-large;">PROJETATU</a></h1>
    
    <p> A Link will be sent to your email adress </p>
    @if (\Session::has('status'))
    <span class="alert-success">
        {!! \Session::get('status') !!}
    </span>
    @endif
    <div>
        <label for="email"></label>
        <input placeholder="email" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <button type="submit">
        Recover Password
    </button>

</form>
@endsection