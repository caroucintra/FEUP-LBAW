<article class="profile" data-id="{{ $user->id }}">
<header>
  <h2><a href="/profile/{{ $user->id }}">{{ $user->name }}</a>
  <span class="rating">
  @for ($i = 0; $i < $user->rating; $i++)
    &#9733;
  @endfor
  @for ($i = 0; $i < (5-$user->rating); $i++)
    &#9734;
  @endfor

  </span>
  @if (Auth::user()->id == $user->id)
    <a href="/profile/{{ $user->id }}/edit" type="button" class="btn btn-primary" style="float:right;"> Edit Profile </a>
    <a href="#" class="delete">Delete Profile</a>
  @else
    @foreach (Auth::user()->followsUsers as $follows)
      @if ($follows->followsUsers->followed_id == $user->id)
        <a id="following" type="button" class="btn btn-primary" style="float:right;"> Following </a>
        @break
      @elseif ($follows->followsUsers->followed_id != $user->id && $loop->last)
        <a id="follow" type="button" class="btn btn-primary" style="float:right;"> Follow </a>
      @endif
    @endforeach
  @endif
 </h2>
</header>

<label class="info">
  <img src="{{$user->img}}">
  <span class="about">
    {{ $user->about }}
  </span>

</label>
</article>
