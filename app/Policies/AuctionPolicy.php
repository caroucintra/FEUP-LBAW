<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AuctionPolicy
{
    use HandlesAuthorization;

    public function list(User $user)
    {
      // Any non-admin can list its own auctions
      return Auth::check() && !$user->admin_permission;
    }

    public function create(User $user)
    {
      // Any non-admin can create a new auction
      return !$user->admin_permission;
    }

    public function delete(User $user, Auction $auction)
    {
      $bids = Bid::where('auction_id',$auction->id)->get();
      // Only a auction owner can delete it
      return $user->id == $auction->user_id && !count($bids);
    }
}
