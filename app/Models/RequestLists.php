<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestLists extends Model
{
    protected $table = 'request_lists';

    protected $fillable = [
        'subject_id', 'object_id', 'list'
    ];
}
