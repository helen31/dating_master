<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    public function whoPay()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function whomPay()
    {
        return $this->belongsTo('App\Models\User', 'girl_id');
    }
}
