<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;

  /**
   * The auction this image belongs to.
   */
  public function auction() {
    return $this->belongsTo('App\Models\Auction');
  }
}
