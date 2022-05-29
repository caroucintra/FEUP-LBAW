<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\AdminRequest;
use App\Models\User;
use App\Models\MoneyTransaction;


class AdminRequestController extends Controller
{
    /**
     * Shows the requests of the admin.
     *
     * @return Response
     */
    public function list()
    {
        $requests = Auth::user()->admin_requests()->orderBy('id','desc');
        return view('pages.admin_requests', ['admin_requests' => $requests]);
    }

    /**
     * Updates the state of an individual request.
     *
     * @param  Request request containing the new state
     * @return Response
     */
    public function update(Request $request)
    {
        $admin_request = AdminRequest::find($request->input('req_id'));
        $admin_request->seen = $request->input('seen');
        $admin_request->save();
        
        echo $admin_request;
        if ($admin_request->type == 'Deposit'){
            $transaction = new MoneyTransaction();
            $transaction->user_id = $admin_request->user_id;
            $transaction->admin_id = $admin_request->admin_id;
            $transaction->type = 'Deposit';
            $transaction->transaction_value = intval($admin_request->amount);
            $transaction->save();
        }

        if ($admin_request->type == 'Debit'){
            $transaction = new MoneyTransaction();
            $transaction->user_id = $admin_request->user_id;
            $transaction->admin_id = $admin_request->admin_id;
            $transaction->type = 'Debit';
            $transaction->transaction_value = intval($admin_request->amount);
            $transaction->save();
        }

        return $admin_request;
    }

}
