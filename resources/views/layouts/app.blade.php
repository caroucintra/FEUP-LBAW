<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel = "shortcut icon" href = "/images/icon.png" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">



    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    <script type="text/javascript" src={{ asset('js/app.js') }} defer>
</script>
  </head>
  <body>
    <main>
      <header>
        <h1><a href="{{ url('/catalog') }}"><img src="/images/logo.png"></a> </h1>
        <div style="float:right;">
          @if (Auth::check())
            @if (!Auth::user()->admin_permission)
            <a type="button" id="notifications" class="btn btn-primary" href="{{ URL::to('/profile/' . Auth::user()->id . '/notifications')}}">
            <i class="fa fa-bell"></i>
              @if (!count(Auth::user()->notifications()->orderBy('id', 'desc')->get()))
                @php
                $badge = False
                @endphp
              @else
                @foreach (Auth::user()->notifications()->orderBy('id', 'desc')->get() as $notification)
                  @if ($notification->seen == False)
                  @php
                  $badge = True
                  @endphp
                  @break
                  @else
                  @php
                  $badge = False
                  @endphp
                  @endif
                @endforeach
              @endif
              <span style="display:{{($badge)? 'block' : 'none'}};"class="badge"> </span>
              </a>
              <div class="nav-item dropdown">
                <button style="margin-left:1em;" type="button" href="#" class="dropbtn btn btn-outline-primary dropdown-toggle show" data-bs-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</button>
                <div class="dropdown-content dropdown-menu" style="">
                  <div class=" dropdown-menu show" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-40px, 5px);" data-popper-placement="bottom-start">
                    <a class="dropdown-item" href="{{ URL::to('/profile/'. Auth::user()->id) }}">Profile</a>
                    <a class="dropdown-item" href="{{ URL::to('/auctions')}}">Create Auction</a>
                    <a class="dropdown-item" href="{{ URL::to('/profile/' . Auth::user()->id . '/bid_history')}}">Bid History</a>
                    <a class="dropdown-item" href="{{ URL::to('/profile/' . Auth::user()->id . '/change_balance')}}">Change Balance</a>
                    <a class="dropdown-item" href="{{ URL::to('/profile/' . Auth::user()->id . '/followers')}}">Followers</a>
                    <a class="dropdown-item" href="{{ URL::to('/profile/' . Auth::user()->id . '/following')}}">Following</a>
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                  </div>
                </div>
              </div>

              <div style="text-align: right; font-size:14px; color:rgba(96, 108, 118);">
                Credit: {{Auth::user()->credit}} €
              </div>
            @else

              <a type="button" id="notifications" class="btn btn-primary" href="{{ URL::to('/admin/' . Auth::user()->id . '/requests')}}">
              <i class="fa fa-bell"></i>
                @if (!count(Auth::user()->admin_requests()->orderBy('id', 'desc')->get()))
                  @php
                  $badge = False
                  @endphp
                @else
                  @foreach (Auth::user()->admin_requests()->orderBy('id', 'desc')->get() as $notification)
                    @if ($notification->seen == False)
                    @php
                    $badge = True
                    @endphp
                    @break
                    @else
                    @php
                    $badge = False
                    @endphp
                    @endif
                  @endforeach
                @endif
                <span style="display:{{($badge)? 'block' : 'none'}};"class="badge"> </span>
                </a>
              <div class="nav-item dropdown">
                <button style="margin-left:1em;" type="button" href="#" class="dropbtn btn btn-outline-primary dropdown-toggle show" data-bs-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</button>
                <div class="dropdown-content dropdown-menu" style="">
                  <div class=" dropdown-menu show" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-67px, 5px);" data-popper-placement="bottom-start">
                    <a class="dropdown-item" href="{{ URL::to('/profile/'. Auth::user()->id) }}">Profile</a>
                    <a class="dropdown-item" href="{{ URL::to('/dashboard/cancel_auction')}}">Cancel Auction</a>
                    <a class="dropdown-item" href="{{ URL::to('/dashboard/delete_comment')}}">Delete Comment</a>
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                  </div>
                </div>
              </div>
            @endif
          @else
            <a type="button" class="btn btn-primary" href="{{ url('/login') }}"> Login </a>
          @endif
        </div>
      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
