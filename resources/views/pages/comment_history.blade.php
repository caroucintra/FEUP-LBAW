@extends('layouts.app')

@section('title', 'comments')

@section('content')
 
<section id="comment_h">
<header><h3>{{json_decode($comments[0]->user()->get('name'), true)[0]['name']}}'s Public Comments</h3></header>
  @each('partials.comment', $comments, 'comment')
</section>


@include('partials.footer')
@endsection
