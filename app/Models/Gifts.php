<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presents;

class Gifts extends Model
{
    use SoftDeletes;

    protected $table = 'gifts';

    protected $fillable = [
        'from', 'to', 'present', 'status_id', 'status_message', 'confirm_photo',
    ];

    public function prezent()  /* Функцию нельзя назвать present, так как уже обявлена такая переменная */
    {
        return $this->hasOne('App\Models\Presents', 'id', 'present')->withTrashed();
    }

    public function status()
    {
        return $this->hasOne('App\Models\GiftStatus');
    }

    public function man()
    {
        return $this->hasOne('App\Models\User', 'id', 'from');
    }
    public function girl()
    {
        return $this->hasOne('App\Models\User', 'id', 'to');
    }

    
}
