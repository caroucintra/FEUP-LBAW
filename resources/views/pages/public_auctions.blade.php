@extends('layouts.app')

@section('title', 'auctions')

@section('content')

<section id="public_auctions">
    <header style="  position: absolute; left: 50%; transform: translate(-50%, 0%);"><h3>
        @if (count($auctions))
        {{json_decode($auctions[0]->user()->get('name'), true)[0]['name']}}'s Public Auctions
        @else
        The user does not have any auctions to display.
        @endif
    </h3></header>
    <ul class="auctions">
        @each('partials.auction', $auctions->filter(function ($auction) {
                    return $auction->deadline > now();}), 'auction')
    </ul>
</section>

<div class="fixed-bottom">
  {{ $auctions->links('vendor.pagination.custom') }}
</div>

@include('partials.footer')
@endsection
