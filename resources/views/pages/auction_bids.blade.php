@extends('layouts.app')

@section('title', 'bids')

@section('content')
 
<section id="auction_bids">
<div class="center">
<header><h3>{{json_decode($bids[0]->auction()->get('name'), true)[0]['name']}}'s Public Bids</h3></header>
  @each('partials.bid', $bids, 'bid')
</section>


@include('partials.footer')
@endsection
