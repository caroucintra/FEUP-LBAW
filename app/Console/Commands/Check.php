<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\GreatestBid;
use App\Models\Auction;
use App\Models\Bid;

class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if auction is over and, if so, who is the winner and tranfers money to seller!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Checks deadline of each auction, decides if it's over and selects the winner, that receives a notification. The auctionner receives the money.
     *
     * @return int
     */
    public function handle()
    {
      $auctionAll = Auction::all();
      for ($i = 0, $size = count($auctionAll); $i < $size; $i++) {
        $auctionDeadline = $auctionAll[$i] -> deadline;
        if($auctionDeadline > now()){
          $greatestBid = $auctionAll[$i]->bid()->bid_value;
          $auctionOwner = $auctionAll[$i]->user()->get();
          $auctionOwner->credit = $auctionOwner->credit + $greatestBid;
          $auctionOwner->save();
        }
      }
      return 0;
    }
}
