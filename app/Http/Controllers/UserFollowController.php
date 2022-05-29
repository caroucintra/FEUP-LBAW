<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserFollow;

class UserFollowController extends Controller{

    public function follow(Request $request, $id)
    {
        $userfollow = new UserFollow();
        $userfollow->followed_id = $id;
        $userfollow->follower_id = Auth::user()->id;
        $userfollow->save();

        return $userfollow;
    }

    public function unfollow(Request $request, $id)
    {
        $userfollows = UserFollow::where('followed_id',$id)->where('follower_id',Auth::user()->id)->get();
        $userfollow = $userfollows[0];
        $userfollow->delete();

        return $userfollow;
    }
}