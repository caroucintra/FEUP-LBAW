@extends('layouts.app')

@section('title', 'user')

@section('content')

<section id="followers">
<header><h3>Followers</h3></header>
<div class="grid2">
@if (count($user->followedBy))
@each('partials.user', $user->followedBy, 'user')
@else
The user does not have any followers.
@endif
</div>
</section>

<div class="fixed-bottom">
    {{ $user->links('vendor.pagination.custom') }}
</div>

@include('partials.footer')
@endsection
