<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
      'App\Models\Auction' => 'App\Policies\AuctionPolicy',
      'App\Models\User' => 'App\Policies\ProfilePolicy',
      'App\Models\Bid' => 'App\Policies\BidPolicy',
      'App\Models\User' => 'App\Policies\DashboardPolicy'

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
