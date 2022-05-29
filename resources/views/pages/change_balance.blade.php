@extends('layouts.app')

@section('title', 'balance')

@section('content')

<section id="balance">
<header><h3>Change Balance<h3></header>
<p>Current Balance: {{Auth::user()->credit}} €</p> 
  <span class="transactions">
  <div>
    <p> <h4>To deposit</h4> money into your account: <br><br> Transfer the amount to this IBAN:<b> 00000000000000000000000</b>, then send us the photo of the transfer confirmation and wait for the approval of our team.<p>
    <form class="deposit" action="/profile/{{Auth::user()->id}}/change_balance/deposit" method="post" enctype="multipart/form-data">
      <input type="number" class="form-control" name="amount" placeholder="Amount"><br>
      <input class="form-control" type="file" name="confirmation"><br>
      <input class="btn btn-primary" type="submit" value="Submit" name="submit">
      {{csrf_field()}}
    </form>
    <p> If everything goes well, the credit should be in/out your account in a few days.</p><br>
  </div>


  <div>
    <p><h4>To withdraw</h4> money from your account: <p> 
    <form class="withdraw" action="/profile/{{Auth::user()->id}}/change_balance/withdraw" method="post">
        <input type="text" class="form-control" name="name" placeholder="Name of the addressee"><br>
        <input type="number" class="form-control" name="amount" placeholder="Amount"><br>
        <input type="text" class="form-control" name="iban" placeholder="IBAN" ><br>
        <input class="btn btn-primary" type="submit" value="Submit">
        {{csrf_field()}}
      </form>
  <div>
</span>

</section>
<br><br>

@include('partials.footer')
@endsection
