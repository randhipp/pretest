<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserBalance;
use App\UserBalanceHistory;


class TransferController extends Controller
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
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // pengurangan saldo pengirim

        $pengirim = auth('api')->user()->id ;

        $userbalance = UserBalance::where( 'user_id', '=', $pengirim )->first();

        if(isset($userbalance)) {
            $id = $userbalance->id;
        } else {
            return error;
        }

        $trx = new UserBalanceHistory;
        $trx->user_balance_id = $id;

        $trx->type = 2 ;
        $trx->trx = $request->trx ;

        $trx->balance_before = $userbalance->balance ;
        $trx->balance_after = $trx->balance_before - $request->trx ;

        $trx->activity = $pengirim."_to_".$penerima."_".$request->trx."_".$request->activity ;
        $trx->ip = $request->ip ;
        $trx->location = $request->location ;
        $trx->user_agent = $request->user_agent ;
        $trx->author = $request->author ;
        $trx->save();

        $userbalance->balance -= $request->trx ;

        $userbalance->save();


        //penambahan saldo penerima

        $penerima = User::findOrFail($request->user_id_penerima)->id;

        $balance_penerima = UserBalance::where( 'user_id', '=', $penerima )->first();

        if(isset($balance_penerima)) {
            $id = $balance_penerima->id;
        } else {
            $balance_penerima = new UserBalance;
            $balance_penerima->user_id = $penerima;
            $balance_penerima->balance = 0 ;
            $balance_penerima->balance_achieve = 0;
            $balance_penerima->save();
            $id = $balance_penerima->id;
        }

        // pengurangan saldo pengirim
        $trx = new UserBalanceHistory;
        $trx->user_balance_id = $id;

        $trx->type = 1 ;
        $trx->trx = $request->trx ;

        $trx->balance_before = $balance_penerima->balance ;
        $trx->balance_after = $trx->balance_before + $request->trx ;

        $trx->activity = $pengirim."_to_".$penerima."_".$request->trx."_".$request->activity ;
        $trx->ip = $request->ip ;
        $trx->location = $request->location ;
        $trx->user_agent = $request->user_agent ;
        $trx->author = $request->author ;
        $trx->save();

        $balance_penerima->balance += $request->trx ;

        $balance_penerima->save();

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
