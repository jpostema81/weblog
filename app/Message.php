<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    
    // enable automatic timestamp update (created_at and update_at)
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function comments() {
        return $this->hasMany('App\Message', 'parent_id');
    }

    public function allCommentsRecursive()
    {
        return $this->comments()->with('allCommentsRecursive');
    }
}
