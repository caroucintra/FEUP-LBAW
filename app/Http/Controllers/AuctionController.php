<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Auction;
use App\Models\Image;
use App\Models\User;


class AuctionController extends Controller
{
    /**
     * Shows the auction for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $auction = Auction::find($id);
      return view('pages.auction', ['auction' => $auction]);
    }

    /**
     * Shows all auctions.
     *
     * @return Response
     */
    public function listcatalog()
    {
      $auctions = Auction::paginate(8);
      return view('pages.catalog', ['auctions' => $auctions]);
    }

    /**
     * Shows all auctions owned by the user and lets them create new ones.
     *
     * @return Response
     */
    public function list()
    {
      if (!Auth::check()) return redirect('/login');
      $this->authorize('list', Auction::class);
      $auctions = Auth::user()->auctions()->orderBy('id')->get();
      return view('pages.auctions', ['auctions' => $auctions]);
    }


    /**
     * Shows all public (active) auctions owned by the user.
     *
     * @return Response
     */
    public function listPublic($id)
    {
      $auctions =  User::find($id)->auctions()->orderBy('id')->paginate(8);
      return view('pages.public_auctions', ['auctions' => $auctions]);
    }

    /**
     * Creates a new auction.
     *
     * @return Auction created.
     */
    public function create(Request $request)
    {
      $auction = new Auction();

      $this->authorize('create', $auction);

      $auction->name = $request->input('name');
      $auction->description = $request->input('description');
      $auction->deadline = $request->input('deadline');
      $auction->initial_price = $request->input('initial_price');
      $auction->user_id = Auth::user()->id;
      $auction->save();
      
      if ($request->file('image') != null) {
        $image = new Image();
        $file = $request->file('image');

        // Generate a file name with extension
        $fileName = 'auctionimage-'.time().'.'.$file->getClientOriginalExtension();

        // Save the file
        $file->storeAs('public/photos', $fileName);
        $image->auction_id = $auction->id;
        $image->address = 'photos/'.$fileName;
        $image->save();
      }
      return view('pages.auction', ['auction' => $auction]);
    }

    /**
     * Deletes an auction.
     *
     * @return Response
     */
    public function delete(Request $request, $id)
    {
      $auction = Auction::find($id);

      $this->authorize('delete', $auction);
      $auction->delete();

      return $auction;
    }

    /**
     * Shows the editting page of the auction.
     *
     * @return Response
     */
    public function editPage($id)
    {
      $auction = Auction::find($id);
      return view('pages.edit_auction', ['auction' => $auction]);
    }

    /**
     * Allows user to update their auction.
     *
     * @return Response
     */
    public function edit(Request $request, $id)
    {
      $auction = Auction::find($id);
      if ($request->input('name') == null) $name = $auction->name;
      else $name = $request->input('name');
      if ($request->input('description') == null) $description = $auction->description;
      else $description = $request->input('description');
      $auction->name = $name;
      $auction->description = $description;

      $auction->save();

      return $auction;
    }

}
