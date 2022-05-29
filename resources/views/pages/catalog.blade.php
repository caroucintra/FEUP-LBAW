@extends('layouts.app')

@section('title', 'catalog')

@section('content')

<section id='catalog_page'>

<div style="width:100%;">
  <article class="search">
    <form action="{{ route('search') }}" method="GET">
        <input type="text" class="form-control" name="search" placeholder="search" required/>
    </form>
  </article>
</div>
<br>
<br>

  <section id="catalog">
    @if (is_array($auctions)) @each('partials.auction', array_filter($auctions,function ($auction) {
            return $auction->deadline > now();}), 'auction')
    @else @each('partials.auction', $auctions->filter(function ($auction) {
            return $auction->deadline > now();}), 'auction')
    @endif
  </section>

</section>

<div class="fixed-bottom">
  {{ $auctions->links('vendor.pagination.custom') }}
</div>

@include('partials.footer')
@endsection
