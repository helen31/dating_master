<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Gifts;
use App\Models\Presents;

class GiftStatus extends Model
{
    protected $table = 'gift_statuses';

    protected $fillable = [
        'name', 'description'
    ];

    public function gifts()
    {
        return $this->belongsToMany('App\Models\Gifts');
    }
    
}
