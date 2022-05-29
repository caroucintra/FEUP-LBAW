@extends('layouts.app')

@section('title', 'notifications')

@section('content')

<section id="notifications" data-id="{{Auth::user()->id}}">
<header><h3>Notifications</h3>
  <label class="checkbox_container"> Check All
    <input style="float:left;" type="checkbox"></input>
    <span class="checkmark"></span>
  </label>
</header>

  <div class="grid2">
    @if ($notifications->count())
      @each('partials.notification', $notifications, 'notification')
    @else
    The user does not have any notifications yet.
    @endif

  </div>
</section>

<div class="fixed-bottom">
  {{ $notifications->links('vendor.pagination.custom') }}
</div>

@include('partials.footer')
@endsection
