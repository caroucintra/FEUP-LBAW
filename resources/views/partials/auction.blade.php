<article class="auction" data-id="{{ $auction->id }}">

  <div class="card border-primary mb-3">
    <div class="card-header">
      <a href="/auctions/{{ $auction->id }}"> {{ $auction->name }} </a>
    </div>
    <div class="card-body" style="padding:0;">
      <ul class="images">
        <rect>
          <a href="/auctions/{{ $auction->id }}">
            @each('partials.image', $auction->images()->orderBy('address')->get(), 'image')
          </a>
        </rect>
      </ul>
      </div>
      <div class="card-footer">
        <label class="details" >
          <div style=" position:absolute; bottom:0;font-size:16px;">
            @if ($auction->bids()->exists())
            <div><b>{{ json_decode($auction->bids()->orderBy('id','desc')->get('bid_value')->first(), true)['bid_value'] }}€</b></div>
            @else
            <div><b>{{ $auction->initial_price }}€</b></div>
            @endif
            <div style="color:rgba(96, 108, 118); font-size:14px;">Deadline: {{ app\Http\Helpers::time_elapsed_string($auction->deadline) }}</div>
          </div>
        </label>
      </div>
    </div>

  </div>
</article>
