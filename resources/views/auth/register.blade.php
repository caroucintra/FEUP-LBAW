@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <div class="form-group">
    <label for="name" class="form-label mt-4">Name</label>
    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="Enter name">
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif
</div>

<div class="form-group">
    <label for="email" class="form-label mt-4">E-Mail Address</label>
    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required placeholder="Enter email">
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input id="password" class="form-control" type="password" name="password" required placeholder="Enter password">
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif
</div>
<div class="form-group">
    <label for="password-confirm" class="form-label mt-4">Confirm Password</label>
    <input id="password-confirm" class="form-control" type="password" name="password_confirmation" required placeholder="Confirm password">
</div>
<br>
    <button class="btn btn-primary" type="submit">
      Register
    </button>
    <a class="btn btn-outline-warning" href="{{ route('login') }}">Login</a>
</form>
@endsection
