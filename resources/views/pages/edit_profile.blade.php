@extends('layouts.app')

@section('title', $user->name)

@section('content')
<article class="edit_profile" data-id="{{ $user->id }}">
    <form class="update_profile">
      <div>Name: <input type="text" class="form-control" name="name" placeholder="{{$user->name}}"></div><br>
      <div>Email:  <input type="email" class="form-control" name="email" placeholder="{{$user->email}}"></div><br>
      <div>About: <input class="form-control" style="height:10em;"type="text" name="about" placeholder="{{$user->about}}"></div><br>
      <input class="btn btn-primary" style="margin-left: 5em;" type="submit" value="Change profile">
    </form>
  </article>

  @include('partials.footer')
@endsection