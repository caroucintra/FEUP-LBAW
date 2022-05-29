<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bid;
use App\Models\User;


class Auction extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  /**
   * The user this auction belongs to
   */
  public function user() {
    return $this->belongsTo('App\Models\User');
  }

  /**
   * Bids inside this auction
   */
  public function bids() {
    return $this->hasMany('App\Models\Bid');
  }

  /**
   * Images inside this auction
   */
  public function images() {
    return $this->hasMany('App\Models\Image');
  }

  /**
   * Comments inside this auction
   */
  public function comments() {
    return $this->hasMany('App\Models\Comment');
  }

  public function categorys() {
    return $this->hasMany('App\Models\Category');
  }

}
