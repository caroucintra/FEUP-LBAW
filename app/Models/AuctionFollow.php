<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Auction;


class AuctionFollow extends Pivot
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

}