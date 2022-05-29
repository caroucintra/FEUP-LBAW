<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Shows the notifications of the user.
     *
     * @return Response
     */
    public function list()
    {
        $notifications = Auth::user()->notifications()->orderBy('id','desc')->paginate(10);
        return view('pages.notifications', ['notifications' => $notifications]);
    }

    /**
     * Updates the state of an individual notification.
     *
     * @param  Request request containing the new state
     * @return Response
     */
    public function update(Request $request)
    {
      $notification = Notification::find($request->input('not_id'));
      $notification->seen = $request->input('seen');
      $notification->save();
      return $notification;
    }

    /**
     * Updates all notifications.
     *
     * @param  Request request containing the new state
     * @return Response
     */
    public function checkAll(Request $request)
    {
        $user = Auth::user();
        foreach($user->notifications()->get() as $notification){
            $notification->seen = True;
            $notification->save();
        }
      return $user;
    }

}
