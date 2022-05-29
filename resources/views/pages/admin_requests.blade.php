@extends('layouts.app')

@section('title', 'admin_requests')

@section('content')

<section id="admin_requests" data-id="{{Auth::user()->id}}">
<header><h3>Admin Requests</h3>
  <label class="checkbox_container"> Check All
    <input style="float:left;" type="checkbox"></input>
    <span class="checkmark"></span>
  </label>
</header>
  <div class="grid2">
    @if ($admin_requests->count())
        @each('partials.admin_request', $admin_requests->get(), 'admin_requests')
    @else
    The admin does not have any requests yet.
    @endif

  </div>
</section>
@include('partials.footer')
@endsection
