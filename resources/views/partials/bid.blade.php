<li class="bid" data-id="{{$bid->id}}">
  <div>{{ $bid->bid_value }}€ </div>
  <span class="user"> &ensp; <a href="/profile/{{json_decode($bid->user()->get('id'), true)[0]['id']}}"> 
    {{json_decode($bid->user()->get('name'), true)[0]['name']}} </a></span>
  <span class="auction"> &ensp; <a href="/auctions/{{json_decode($bid->auction()->get('id'), true)[0]['id']}}">
    {{json_decode($bid->auction()->get('name'), true)[0]['name']}} </a></span>
  <span style="color:rgba(96, 108, 118); font-size:14px;"> &ensp;
    {{ app\Http\Helpers::time_elapsed_string($bid->bid_date) }} ago </span>

</li>
