<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Auction;
use App\Models\AuctionFollow;

class AuctionFollowController extends Controller{

    public function follow(Request $request, $id)
    {
        $auctionfollow = new AuctionFollow();
        $auctionfollow->user_id =  Auth::user()->id;
        $auctionfollow->auction_id = $id;
        $auctionfollow->save();

        return $auctionfollow;
    }

    public function unfollow(Request $request, $id)
    {
        $auctionfollows = AuctionFollow::where('auction_id',$id)->where('user_id',Auth::user()->id)->get();
        $auctionfollow = $auctionfollows[0];
        $auctionfollow->delete();

        return $auctionfollow;
    }
}