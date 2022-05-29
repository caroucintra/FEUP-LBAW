@extends('layouts.app')

@section('title', $auction->name)

@section('content')
<section id="auction_page" data-id="{{ $auction->id }}">
  <article class="auction_page" data-id="{{ $auction->id }}">
  <header>
    <h2><a href="/auctions/{{ $auction->id }}">{{ $auction->name }}</a>
    @if (Auth::check())
      @if (Auth::user()->id == $auction->user_id)
        <a href="/auctions/{{ $auction->id }}/edit" type="button" class="btn btn-primary edit" style="float:right;"> Edit Auction </a>
        <a href="#" class="delete">Cancel Auction</a>
      @else
        @foreach (Auth::user()->followsAuctions as $follows)
          @if ($follows->followsAuctions->auction_id == $auction->id)
            <a id="following" type="button" class="btn btn-primary" style="float:right;"> Following </a>
            @break
          @elseif ($follows->followsAuctions->auction_id != $auction->id && $loop->last)
            <a id="follow" type="button" class="btn btn-primary" style="float:right;"> Follow </a>  
          @endif
        @endforeach
      @endif
    @endif
  </h2>
  </header>

  <div>
  <ul class="images">
    @each('partials.image', $auction->images()->get(), 'image')
  </ul>

  <div style ="display: grid; grid-template-columns: repeat(2, 1fr);">  
    <div class="card border-primary mb-3" id="details">
      <h3 class="card-header">Details: </h3>
      <div class="card-body">
        Description: {{ $auction->description }} <br>
        Artist: <a href="/profile/{{ $auction->user_id }}"> {{json_decode($auction->user()->get('name'), true)[0]['name']}} </a><br>
        Initial price: {{ $auction->initial_price }}€ <br>
        Deadline: {{ $auction->deadline }}</div> <br>
    </div>
    

    <div class="card border-primary mb-3" id="bids">
      <h3 class="card-header"> Make a new bid:</h3>
      <form class="new_bid">
        <div class="form-group">
          <input type="number" class="form-control" name="bid_value" placeholder="new bid">
        </div>
        <input class="btn btn-primary" type="submit" value="Make bid">
      </form>
      <p></p>
      <div class="card-body prevbids">
        <h3>Bids: <a href="/auctions/{{ $auction->id }}/bids" type="button" class="btn btn-primary" style="float:right;"> See more </a></h3> 
        <ul>
        @foreach ($auction->bids()->orderBy('id', 'desc')->get() as $bid)
            @if ($loop->index == 3) @break
            @else
              @include('partials.bid', $bid)
            @endif
          @endforeach
        </ul>
      </div>
    </div>
  </div>

    <div class="card border-primary mb-3" id="comments" style="float:left;">
      <h3 class="card-header"> Comments: <a href="/auctions/{{ $auction->id }}/comments" type="button" class="btn btn-primary" style="float:right;"> See more </a></h3>
      <form class="new_comment">
        <div class="form-group">
          <input type="text" class="form-control" name="comment" placeholder="new comment">
        </div>
        <input class="btn btn-primary" type="submit" value="Make comment">
      </form>
      <p></p>
        <ul>
          @foreach ($auction->comments()->orderBy('id', 'desc')->get() as $comment)
            @if ($loop->index == 3) @break
            @else
              @include('partials.comment', $comment)
            @endif
          @endforeach
        </ul>
    </div>
  </div>

  </article>
</section>


@include('partials.footer')
@endsection