<?php

namespace App\Http\Controllers\Static;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AboutController extends Controller
{
    /**
     * Shows the about page.
     *
     * @return Response
     */
    public function show()
    {
      return view('pages.about');
    }

}
