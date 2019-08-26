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

    // parent message (if child)
    public function message()
    {
        return $this->belongsTo('App\Message', 'parent_id');
    }

    // public function message()
    // {
    //     return $this->belongsTo(Self::class, 'parent_id')->with('message');
    // }

    // children messages (if parent)
    public function comments() {
        return $this->hasMany('App\Message', 'parent_id');
    }

    // get all child messages (comments) recursively
    public function allCommentsRecursive()
    {
        return $this->comments()->with('allCommentsRecursive');
    }

    public function categories() {
        return $this->belongsToMany('App\Category');
    }
}
