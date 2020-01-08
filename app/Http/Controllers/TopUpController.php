<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserBalance;
use App\UserBalanceHistory;


class TopUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userbalance = UserBalance::find(auth('api')->user()->id);

        if($userbalance) {
            $id = $userbalance->id;
        } else {
            $userbalance = new UserBalance;
            $userbalance->user_id = auth('api')->user()->id;
            $userbalance->balance = 0 ;
            $userbalance->balance_achieve = 0;
            $userbalance->save();
            $id = $userbalance->id;
        }

        $trx = new UserBalanceHistory;
        $trx->user_balance_id = $id;
        $trx->balance_before = $userbalance ? $userbalance->balance : 0 ;
        $trx->balance_after = $request->trx ;
        $trx->activity = $request->activity ;
        $trx->type = $request->type ;
        $trx->ip = $request->ip ;
        $trx->location = $request->location ;
        $trx->user_agent = $request->user_agent ;
        $trx->author = $request->author ;
        $trx->save();

        if($trx->type == 0) {
            $userbalance->balance += $request->trx ;
        } else {
            $userbalance->balance -= $request->trx ;
        }

        $userbalance->save();

        return $trx;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
