<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Lists extends Model
{
    protected $table = 'lists';

    protected $fillable = [
        'subject_id', 'object_id'
    ];
}