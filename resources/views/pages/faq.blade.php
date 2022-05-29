@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<header class=static_page>
  <h2><a href="/faq">FAQ</a></h2>
</header>
<section class=static_page id="faq_page">
    <div class=question>Why choose The Absolute Artion?</div>
    <div class=answer>We make it our daily job to provide the best experience with auctioning to anyone who might be interested in it,
      while giving the platform to share and value real and original art pieces.</div><br>

    <div class=question>How do I start an auction?</div>
    <div class=answer>To create an auction, you must have an account on the platform.
      You can easily create an auction, all you have to do is go to <a href="/auctions">your auctions</a> and fill the form with essential
    information about it. Afterwards, you can edit it and make it beautiful and appealing with images and a description!</div><br>

    <div class=question>How do I make a bid?</div>
    <div class=answer>To make a new bid on someone else's auction you must have an account on the platform. All you need to do is go to the auction of the item you are interested in, and
      look for "Make a new bid". You will find a box where you can insert the value of your bid (make sure it is higher than the previous bid made),
      and just click on the button that says "Make bid", and it is done! Good bidding!</div><br>
</section>

@include('partials.footer')
@endsection
