<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    // enable automatic timestamp update (created_at and update_at)
    public $timestamps = true;

    // these attributes are mass-assignable
    protected $fillable = [
        'title', 'content'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    // public function childrenMessages()
    // {
    //     return $this->hasMany(Self::class, 'parent_id', 'id');
    // }

    // public function allChildrenMessages()
    // {
    //     return $this->childrenMessages()->with('allChildrenMessages');
    // }

    public function categories() {
        return $this->belongsToMany('App\Category');
    }
}
