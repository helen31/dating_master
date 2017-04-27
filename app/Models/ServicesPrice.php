<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesPrice extends Model
{
    protected $table = 'services_price';

    protected $fillable = [
        'name', 'price', 'term',
    ];

}
