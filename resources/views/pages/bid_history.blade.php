@extends('layouts.app')

@section('title', 'bids')

@section('content')

<section id="bid_h">
<div class="center">
<header><h3>Bid History</h3></header>
  @each('partials.bid', $bids, 'bid')
</div>
</section>


@include('partials.footer')
@endsection