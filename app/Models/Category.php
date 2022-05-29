<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;


    /**
     * The auctions this category is associated to.
     */
    public function auction() {
        return $this->hasMany('App\Models\Auction');
    }
}
