<?php

namespace App\Http\Controllers\Static;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ServicesController extends Controller
{
    /**
     * Shows the services page.
     *
     * @return Response
     */
    public function show()
    {
      return view('pages.services');
    }

}
