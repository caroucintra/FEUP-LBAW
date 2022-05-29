@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <div class="form-group">
      <label for="email" class="form-label mt-4">Email address</label>
      <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required autofocus placeholder="Enter email">
      
        @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
        @endif
    </div>

    <div class="form-group">
        <label for="password" class="form-label mt-4">Password</label>
        <input id="password" class="form-control" type="password" name="password" required autofocus placeholder="Enter password">
        @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
        @endif
    </div>

    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" name="remember" {{ old('remember') ? 'checked' : '' }}>
        Remember Me
    </div>
    <button class="btn btn-primary" type="submit">
            Login
    </button>
    <a class="btn btn-outline-warning" href="{{ route('register') }}">Register</a>
</form>
@endsection
