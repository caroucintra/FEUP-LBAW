<li class="comment" data-id="{{$comment->id}}">
    <span class="user"><a href="/profile/{{json_decode($comment->user()->get('id'), true)[0]['id']}}"> 
    {{json_decode($comment->user()->get('name'), true)[0]['name']}} </a></span>
    
    <div>&ensp; {{ $comment->comment_text }} </div>

    <div style="color:rgba(96, 108, 118); font-size:14px;"> &ensp; {{ app\Http\Helpers::time_elapsed_string($comment->comment_date) }} ago </div>
</li>
