<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DashboardPolicy
{
    use HandlesAuthorization;

    public function show(User $user)
    {
      // Only admins can see the dashboard
      return $user->admin_permission;
    }
}