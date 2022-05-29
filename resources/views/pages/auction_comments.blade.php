@extends('layouts.app')

@section('title', 'comments')

@section('content')
 
<section id="auction_comments">
<div class="center">
<header><h3>{{json_decode($comments[0]->auction()->get('name'), true)[0]['name']}}'s Public Comments</h3></header>
  @each('partials.comment', $comments, 'comment')
</div>
</section>



@include('partials.footer')
@endsection
