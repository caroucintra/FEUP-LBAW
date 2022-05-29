<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Notification extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
    * The user this notification belongs to
    */
    public function user() {
        return $this->belongsTo('App\Models\User');
  }

    /**
    * The auction this notification is about
    */
    public function auction() {
        return $this->belongsTo('App\Models\Auction');
  }

      /**
    * The comment this notification is about
    */
    public function comment() {
        return $this->belongsTo('App\Models\Comment');
  }

      /**
    * The bid this notification is about
    */
    public function bid() {
        return $this->belongsTo('App\Models\Bid');
  }

      /**
    * The follower this notification is about
    */
    public function follower() {
        return $this->belongsTo('App\Models\User', 'follower_id');
  }

}