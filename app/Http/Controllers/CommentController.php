<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Comment;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Shows the comment for a given id.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $comment = Comment::find($id);
      return view('pages.comment', ['comment' => $comment]);
    }


    /**
     * Creates a new comment.
     *
     * @param  int  $id
     * @param  Request request containing the description
     * @return Response
     */
    public function create(Request $request, $id)
    {
        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->auction_id = $id;
        $comment->comment_text = $request->input('comment');
        $comment->save();

        return $comment;
    }

    /**
     * Shows all comments made by the user.
     *
     * @return Response
     */
    public function listByUser(){
        $this->authorize('listByUser', Comment::class);
        $comments = Auth::user()->comments()->orderBy('id','desc')->get();
        return view('pages.comment_history', ['comments' => $comments]);
    }

    /**
     * Shows all comments made by in an auction.
     *
     * @return Response
     */
    public function listByAuction($id){
        $comments = Auction::find($id)->comments()->orderBy('id','desc')->get();
        return view('pages.auction_comments', ['comments' => $comments]);
    }

}