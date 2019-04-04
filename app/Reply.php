<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public $guarded=[];

    public function owner()
    {
        return $this->belongsTo(User::class,"user_id");
    }
}
