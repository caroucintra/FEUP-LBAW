<li class="admin_requests" data-id="{{$admin_requests->id}}">
<article class="user_notif" data-id="{{$admin_requests->admin_id}}">

<label class="checkbox_container">
  <input style="float:left;" {{ $admin_requests->seen ? 'checked' : '' }} type="checkbox"></input>
  <span class="checkmark"></span>
</label>


@if ($admin_requests->type == 'Deposit')

    <div style="display:flex; flex-direction:column;  margin: 1em;">
        <div>
            <a href="/profile/{{json_decode($admin_requests->user()->get('id'), true)[0]['id']}}">
            &ensp; {{json_decode($admin_requests->user()->get('name'), true)[0]['name']}}&nbsp;
            </a>
            wants to make a deposit of {{$admin_requests->amount}}€
        </div>
    </div>

@elseif ($admin_requests->type == 'Debit')

<div style="display:flex; flex-direction:column;  margin: 1em;">
    <div>
        <a href="/profile/{{json_decode($admin_requests->user()->get('id'), true)[0]['id']}}">
        &ensp; {{json_decode($admin_requests->user()->get('name'), true)[0]['name']}}&nbsp;
        </a>
        wants to make a debit of {{$admin_requests->amount}}€
    </div>
</div>

@endif

<br>
</article>
</li>
