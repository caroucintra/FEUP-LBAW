<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The auctions this user owns.
     */
     public function auctions() {
      return $this->hasMany('App\Models\Auction');
    }

    /**
     * The bids this user has made.
     */
    public function bids() {
        return $this->hasMany('App\Models\Bid');
    }

    /**
     * The comments this user has made.
     */
    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * The notifications this user has.
     */
    public function notifications() {
        return $this->hasMany('App\Models\Notification');
    }

    /**
     * The requests this admin has.
     */
    public function admin_requests() {
        return $this->hasMany('App\Models\AdminRequest', 'admin_id');
    }

    /**
     * The users this user follows.
     */
    public function followsUsers() {
        return $this->belongsToMany('App\Models\User', 'user_follow', 'follower_id', 'followed_id')->as('followsUsers')->using('App\Models\UserFollow');
    }

    /**
     * This user's followers.
     */
    public function followedBy() {
        return $this->belongsToMany('App\Models\User', 'user_follow', 'followed_id', 'follower_id')->as('followedBy')->using('App\Models\UserFollow');
    }

    /**
     * The auctions this user follows.
     */
    public function followsAuctions() {
        return $this->belongsToMany('App\Models\Auction', 'auction_follow')->as('followsAuctions')->using('App\Models\AuctionFollow');
    }
}
