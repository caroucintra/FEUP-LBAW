@extends('layouts.app')

@section('title', 'auctions')

@section('content')

<section id="auctions">
  <article class="auction">
    <h3>Create auction: </h3>
    <form action="/auctions" method="POST" enctype="multipart/form-data">
      <input type="text" class="form-control" name="name" placeholder="name" required>
      <input type="text" class="form-control" name="description" placeholder="description" required>
      <input type="number" class="form-control" name="initial_price" placeholder="initial price" required>
      <input type="datetime-local" class="form-control" name="deadline" placeholder="deadline (format: YYYY-MM-DD HH:MM:SS)" required>
      <input type="file" class="form-control" name="image" id="image">
      <input type="submit" class="btn btn-primary" value="Create">
      {{csrf_field()}}
    </form>
  </article>
  @each('partials.auction', $auctions, 'auction')

</section>

@include('partials.footer')
@endsection
