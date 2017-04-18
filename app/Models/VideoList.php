<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoList extends Model
{
    protected $table = 'video_lists';

    protected $fillable = [
        'subject_id', 'video_id'
    ];
}
