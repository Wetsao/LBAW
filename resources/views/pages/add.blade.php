@extends('layouts.app')
@section('title', 'Add')
@section('content')
<form action="{{url('insertProject')}}"method="POST" >
    {{ csrf_field() }}
<h1> <a href="{{ url('/homepage') }}" style="color: black; text-decoration:none; font-size:xxx-large;"> <img
                src="/images/logo.png" style="filter: invert(100%); max-width: 20%; max-height: 20%"> PROJETATU</a></h1>
    <label for="name"></label>
    <input placeholder="name*" id="name" type="name" name="name" required autofocus>

    <label for="details"></label>
    <input placeholder="details*" id="name" type="name" name="details"  required>

    <input type="date" name="delivery" placeholder="01/01/2001" onfocus="(this.type='date')" required>

    <a href="{{ url('/homepage') }}">
      <div><button type="submit">
        Create
      </button>
      </div>
    </a>

    @if(session()->has('message'))
    <div class="alert alert-success">
      {{ session()->get('message') }}
    </div>
    @endif
</form>
@endsection