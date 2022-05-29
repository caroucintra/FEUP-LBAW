<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GreatestBid extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  public function bid() {
    return $this->belongsTo('App\Models\Bid');
  }

  /**
   * The auction this bid belongs to.
   */
  public function auction() {
    return $this->belongsTo('App\Models\Auction');
  }
}