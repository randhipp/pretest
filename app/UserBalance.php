<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    protected $table = 'user_balance';

    public function history()
    {
        return $this->hasMany('App\UserBalanceHistory');
    }
}
