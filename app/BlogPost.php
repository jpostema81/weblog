<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    // enable automatic timestamp update (created_at and update_at)
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}
