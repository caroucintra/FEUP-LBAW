@extends('layouts.app')

@section('title', 'user')

@section('content')

<section id="following">
<header><h3>Following</h3></header>
<div class="grid2">
@if (count($user->followsUsers))
@each('partials.user', $user->followsUsers, 'user')
@else
The user does not follow anyone.
@endif
</div>
</section>

<div class="fixed-bottom">
    {{ $user->links('vendor.pagination.custom') }}
</div>

@include('partials.footer')
@endsection
