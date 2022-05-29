<?php

namespace App\Http\Controllers\Static;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ContactController extends Controller
{
    /**
     * Shows the contact page.
     *
     * @return Response
     */
    public function show()
    {
      return view('pages.contact');
    }

}
