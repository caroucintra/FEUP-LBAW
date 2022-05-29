<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function show(User $user)
    {
      // In case it's an admin profile, only admins can see it. Otherwise, anyone can
      return $user->admin_permission;
    }

    public function editPage(User $user)
    {
      return $user->id == json_decode(Auth::check()->user()->get('id'), true)[0]['id'];
    }

    public function edit(User $user)
    {
      // Only the owner of the profile can edit it
      return true;
    }

    public function delete(User $user)
    {
      // Only a auction owner can delete it
      return $user->id == Auth::user()->id;
    }
  }
