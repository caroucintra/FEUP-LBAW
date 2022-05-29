@extends('layouts.app')

@section('title', $auction->name)

@section('content')
<article class="edit_auction" data-id="{{ $auction->id }}">
    <form class="update_auction">
      <div>Name: <input class="form-control" type="text" name="name" placeholder="{{$auction->name}}"></div><br>
      <div>Description:  <input class="form-control" type="text" name="description" placeholder="{{$auction->description}}"></div><br>
      <input class="btn btn-primary" style="margin-left: 5em;" type="submit" value="Change auction">
    </form>
</article>

@include('partials.footer')
@endsection