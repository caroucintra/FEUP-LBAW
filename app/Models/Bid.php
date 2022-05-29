<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

    /**
   * The user this bid belongs to.
   */
  public function user() {
    return $this->belongsTo('App\Models\User');
  }

  /**
   * The auction this bid belongs to.
   */
  public function auction() {
    return $this->belongsTo('App\Models\Auction');
  }
}
