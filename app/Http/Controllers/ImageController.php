<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function displayImage($filename)
    {
        $path = storage_public($filename);
        if (!File::exists($path)) {

            abort(404);

        }

        $file = File::get($path);

        $type = File::mimeType($path);

        $response = Response::make($file, 200);

        $response->header("Content-Type", $type);

        return $response;
    }
}