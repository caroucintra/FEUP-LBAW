<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Auction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{

/**
   * Shows the bid for a given id.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    $bid = Bid::find($id);
    return view('pages.bid', ['bid' => $bid]);
  }


  /**
   * Creates a new bid.
   *
   * @param  int  $auction_id
   * @param  Request request containing the description
   * @return Response
   */
  public function create(Request $request, $auction_id)
  {
    $bid = new Bid();
    $bid->auction_id = $auction_id;
    $bid->user_id = Auth::user()->id;
    $this->authorize('create', $bid);
    
    $bid->bid_value = $request->input('bid_value');

    $bid->save();
    return $bid;
  }

    /**
   * Shows all bids made by the user.
   *
   * @return Response
   */
  public function listByUser(){
    if (!Auth::check()) return redirect('/login');
    $this->authorize('listByUser', Bid::class);
    $bids = Auth::user()->bids()->orderBy('id','desc')->get();
    return view('pages.bid_history', ['bids' => $bids]);
  }

  /**
   * Shows all bids made in an auction.
   *
   * @return Response
   */
  public function listByAuction($id){
    $bids = Auction::find($id)->bids()->orderBy('id','desc')->get();
    return view('pages.auction_bids', ['bids' => $bids]);
  }


    /**
     * Updates the state of an individual bid.
     *
     * @param  int  $id
     * @param  Request request containing the new state
     * @return Response
     */
    /*
    public function update(Request $request, $id)
    {
      $bid = Bid::find($id);
      $this->authorize('update', $bid);
      $bid->done = $request->input('done');
      $bid->save();
      return $bid;
    }
    */

    /**
     * Deletes an individual bid.
     *
     * @param  int  $id
     * @return Response
     */
    /*
    public function delete(Request $request, $id)
    {
      $bid = Bid::find($id);
      $this->authorize('delete', $bid);
      $bid->delete();
      return $bid;
    }
    */

}
