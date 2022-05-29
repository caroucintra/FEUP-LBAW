<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Shows the contact page.
     *
     * @return Response
     */
    public function show()
    {
      $user = Auth::user();
      $this->authorize('show', $user);
      return view('pages.dashboard');
    }

}
