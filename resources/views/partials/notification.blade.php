<li class="notification" data-id="{{$notification->id}}">
<article class="user_notif" data-id="{{$notification->user_id}}">

<label class="checkbox_container">
  <input style="float:left;" {{ $notification->seen ? 'checked' : '' }} type="checkbox"></input>
  <span class="checkmark"></span>
</label>


@if ($notification->type == 'New Bid')

    <img style="float:left;" src="{{json_decode($notification->bid()->get()[0]->user()->get('img'), true)[0]['img']}}">
    <div style="display:flex; flex-direction:column;  margin: 1em;">
        <div>
        <a href="/profile/{{json_decode($notification->bid()->get('user_id'), true)[0]['user_id']}}">
        &ensp; {{json_decode($notification->bid()->get()[0]->user()->get('name'), true)[0]['name']}}&nbsp;
        </a>
        just made a bid of {{json_decode($notification->bid()->get('bid_value'), true)[0]['bid_value']}}€ on
        &nbsp;<a href="/auctions/{{json_decode($notification->bid()->get('auction_id'), true)[0]['auction_id']}}"> 
        {{json_decode($notification->bid()->get()[0]->auction()->get('name'), true)[0]['name']}}
        </a>
        </div>
    <span style="color:rgba(96, 108, 118); font-size:14px;"> &ensp;
    {{ app\Http\Helpers::time_elapsed_string($notification->notification_date) }} ago </span>
    </div>

@elseif ($notification->type == 'New Comment')

    <img style="float:left;" src="{{json_decode($notification->comment()->get()[0]->user()->get('img'), true)[0]['img']}}">
    <div style="display:flex; flex-direction:column;  margin: 1em;">
        <div>
        <a href="/profile/{{json_decode($notification->comment()->get('user_id'), true)[0]['user_id']}}">
        &ensp; {{json_decode($notification->comment()->get()[0]->user()->get('name'), true)[0]['name']}}&nbsp;
        </a>
        just commented "{{json_decode($notification->comment()->get('comment_text'), true)[0]['comment_text']}}" on 
        &nbsp;<a href="/auctions/{{json_decode($notification->comment()->get('auction_id'), true)[0]['auction_id']}}">
        {{json_decode($notification->comment()->get()[0]->auction()->get('name'), true)[0]['name']}}
        </a>
        </div>
    <span style="color:rgba(96, 108, 118); font-size:14px;"> &ensp;
    {{ app\Http\Helpers::time_elapsed_string($notification->notification_date) }} ago </span>
    </div>

@elseif ($notification->type == 'New Auction')

    <img style="float:left;" src="{{json_decode($notification->auction()->get()[0]->user()->get('img'), true)[0]['img']}}">
    <div style="display:flex; flex-direction:column;  margin: 1em;">
        <div>
        <a href="/profile/{{json_decode($notification->auction()->get('user_id'), true)[0]['user_id']}}">
        &ensp; {{json_decode($notification->auction()->get()[0]->user()->get('name'), true)[0]['name']}} &nbsp;
        </a>
        just created a new auction 
        &nbsp;<a href="/auctions/{{json_decode($notification->auction()->get('id'), true)[0]['id']}}">
        "{{json_decode($notification->auction()->get('name'), true)[0]['name']}}" 
        </a>
        </div>
    <span style="color:rgba(96, 108, 118); font-size:14px;"> &ensp;
    {{ app\Http\Helpers::time_elapsed_string($notification->notification_date) }} ago </span>
    </div>

@elseif ($notification->type == 'New Follower')

    <img style="float:left;" src="{{json_decode($notification->follower()->get('img'), true)[0]['img']}}">
    <div style="display:flex; flex-direction:column;  margin: 1em;">
        <div>
        <a href="/profile/{{json_decode($notification->follower()->get('id'), true)[0]['id']}}">
        &ensp; {{json_decode($notification->follower()->get('name'), true)[0]['name']}}&nbsp;
        </a>
        just followed you
        </div>
    <span style="color:rgba(96, 108, 118); font-size:14px;"> &ensp;
    {{ app\Http\Helpers::time_elapsed_string($notification->notification_date) }} ago </span>
    </div>

@endif

<br>
</article>
</li>
