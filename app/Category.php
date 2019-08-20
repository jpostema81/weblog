<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function message()
    {
        return $this->belongsToMany('App\Message');
    }
}
