<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Auction;

class SearchController extends Controller
{
    /**
     * Shows all auctions according to a given searchParameter.
     *
     * @return Response
     */
    public function searchList(Request $request)
    {
      $searchParameter = strtolower($request->input('search'));
      $auctionSearched = [];
      $auctionAll = Auction::all();
      $sizeResponse = 0;
  
      for ($i = 0, $size = count($auctionAll); $i < $size; $i++) {
        $title = strtolower($auctionAll[$i] -> name);
        $description = strtolower($auctionAll[$i] -> description);
        $name = strtolower(json_decode($auctionAll[$i]->user()->get('name'), true)[0]['name']);
  
        if (strpos($searchParameter, $title) !== false
            || strpos($title, $searchParameter) !== false
            || strpos($searchParameter, $description) !== false
            || strpos($searchParameter, $name) !== false
            || strpos($name, $searchParameter !== false)){
              $auctionSearched[$sizeResponse] = $auctionAll[$i];
              $sizeResponse++;
              continue;
        }
        else{
          foreach($auctionAll[$i]->categorys()->get() as $category){ 
            if (strpos(strtolower($category->type), $searchParameter) !== false
            || strpos($searchParameter, strtolower($category->type) !== false)) {
              $auctionSearched[$sizeResponse] = $auctionAll[$i];
              $sizeResponse++;
              break;
            }
          }
        }
      }
  
      $data = $this->paginate($auctionSearched);
      return view('pages.catalog', ['auctions' => $data]);
    }
  

  public function paginate($items, $perPage = 8, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
