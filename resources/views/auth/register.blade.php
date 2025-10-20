@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    <h1><img style="filter: invert(100%);"  src="/images/logo.png" > <a style="color: black; text-decoration:none; font-size:xxx-large;">PROJETATU</a></h1>

    <label for="name"></label>
    <input placeholder="name*" id="name" type="name" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label for="email"></label>
    <input placeholder="email*" id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password"></label>
    <input placeholder="password*" id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm"></label>
    <input placeholder="confirm password*" id="password-confirm" type="password" name="password_confirmation" required>

    <button type="submit">
      Register
    </button>
    <a class="button button-outline" href="{{ route('login') }}">Login</a>
</form>
@endsection