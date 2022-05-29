@extends('layouts.app')

@section('title', $user->name)

@section('content')
<section id="profile" data-id="{{ $user->id }}">
    <section class="top_part">
        @include('partials.profile', ['user' => $user])
        @if ($user->admin_permission == True)
        <div class="dashboard">
            <h3><a href="/dashboard"><u>Admin Dashboard</u> </a></h3>
        </div>
        @endif
    </section>
    @if ($user->admin_permission == False)
    <section class="bottom_part">
        <h3>Active Auctions:  <a href="/profile/public_auctions/{{ $user->id }}" type="button" class="btn btn-primary" style="float:right;"> See more </a></h3>
        <span>
            <ul class="auctions">
            @foreach ($user->auctions()->orderBy('id', 'desc')->get()->filter(function ($auction) {
                    return $auction->deadline > now();}) as $auction)
                    @if ($loop->index == 4) @break
                    @else
                        @include('partials.auction', $auction)
                    @endif
                @endforeach
            </ul>
        </span>
    </section>
    @endif

</section>

@include('partials.footer')
@endsection
