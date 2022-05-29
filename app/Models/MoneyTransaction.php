<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Auction;


class MoneyTransaction extends Model
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
    * The user that made this transaction
    */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
    * The admin that approved this transaction
    */
    public function admin() {
        return $this->belongsTo('App\Models\User', 'admin_id');
    }

    /**
    * The auction this transaction is about
    */
    public function auction() {
        return $this->belongsTo('App\Models\Auction');
    }
}