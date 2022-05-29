<?php

namespace App\Policies;

use \Datetime;
use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;


class CommentPolicy
{
    use HandlesAuthorization;

    
    public function listByUser(User $user)
    {
      // Only the owner of the profile can list their comments
      return Auth::user()->id == $user->id;
    }

}
