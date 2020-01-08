<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalanceHistory extends Model
{
    protected $table = 'user_balance_history';

    public function balance()
    {
        return $this->belongsTo('App\UserBalance');
    }
}
