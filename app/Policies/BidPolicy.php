<?php

namespace App\Policies;

use \Datetime;
use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;


class BidPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Bid $bid)
    {
      $auction = Auction::find($bid->auction_id);
      
      return $user->id == $bid->user_id && $auction->user_id != $bid->user_id;
    }

    public function update(User $user, Bid $bid)
    {
      // User can only update bids they own
      return $user->id == $bid->user_id;
    }

    public function delete(User $user, Bid $bid)
    {
      // User can only delete bids they own
      return $user->id == $bid->user_id;
    }

    public function listByUser(User $user)
    {
      // Only the owner of the profile can list their bids
      return Auth::user()->id == $user->id;
    }



}
