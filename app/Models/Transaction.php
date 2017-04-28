<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    public function whoPay()
    {
        return $this->belongsTo('App\Models\Users', 'user_id');
    }

    public function whomPay()
    {
        return $this->belongsTo('App\Models\Users', 'girl_id');
    }
}
