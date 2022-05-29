<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\AdminRequest;


class ProfileController extends Controller
{
    /**
     * Shows the profile for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $user = User::find($id);
      if($user->admin_permission) $this->authorize('show', $user);
      return view('pages.profile', ['user' => $user]);
    }

    /**
     * Allows user to update their profile.
     *
     * @return Response
     */
    public function edit(Request $request, $id)
    {
      $user = User::find($id);
      if ($request->input('name') == null) $name = $user->name;
      else $name = $request->input('name');
      if ($request->input('email') == null) $email = $user->email;
      else $email = $request->input('email');
      if ($request->input('about') == null) $about = $user->about;
      else $about = $request->input('about');
      $user->name = $name;
      $user->about = $about;
      $user->email = $email;

      $user->save();

      return $user;
    }

    /**
     * Shows the editting page of the profile.
     *
     * @return Response
     */
    public function editPage($id)
    {
      $user = User::find($id);
      return view('pages.edit_profile', ['user' => $user]);
    }

    /**
     * Lets a user delete their profile
     *
     * @return Response
     */
    public function delete(Request $request, $id)
    {
      $user2 = User::find($id);

      $this->authorize('delete', $user2);
      $user2->delete();

      return $user2;
    }

    public function listFollowers()
    {
      $user = Auth::user()->paginate(2);
      return view('pages.followers', ['user' => $user]);
    }

    public function listFollowing()
    {
      $user = Auth::user()->paginate(2);
      return view('pages.following', ['user' => $user]);
    }

    public function credit()
    {
      $user = Auth::user();
      return view('pages.change_balance',['user' => $user]);
    }

    public function withdrawCredit(Request $request)
    {
      $user = Auth::user();
      $amount = $request->input('amount');
      if ($amount <= $user->credit) {
        foreach (User::all() as $findAdmin)
          if ($findAdmin->admin_permission) {
            $admin = $findAdmin;
            break;
          }
          $admin_request = new AdminRequest();
          $admin_request->user_id = $user->id;
          $admin_request->admin_id = $admin->id;
          $admin_request->type = 'Debit';
          $admin_request->amount = $request->input('amount');
          $admin_request->save();
      }

      return view('pages.change_balance',['user' => $user]);
    }

    public function depositCredit(Request $request)
    {
      $user = Auth::user();
      foreach (User::all() as $findAdmin)
        if ($findAdmin->admin_permission) {
          $admin = $findAdmin;
          break;
        }
      
      $admin_request = new AdminRequest();
      $admin_request->user_id = $user->id;
      $admin_request->admin_id = $admin->id;
      $admin_request->type = 'Deposit';
      $admin_request->amount = $request->input('amount');
      $admin_request->save();

      return view('pages.change_balance',['user' => $user]);
    }
}
