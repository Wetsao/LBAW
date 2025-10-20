@extends('layouts.app')
@section('content')



<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}
    <h1><img style="filter: invert(100%);" src="/images/logo.png" > <a style="color: black; text-decoration:none; font-size:xxx-large;">PROJETATU</a></h1>

    <label for="email"></label>
    <input placeholder="email" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" ></label>
    <input placeholder="password" id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    

    <button type="submit" >
        Login
    </button>
    
    <label>
      <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} > Remember Me
    </label>
    <a class="button button-outline" href="{{ route('register') }}">Register</a>
    <a class="button button-outline" href="{{ route('password.request') }}">Forgot Password</a>
    @if (session('success'))
        <p class="success">
            {{ session('success') }}
        </p>
    @endif
</form>
@endsection