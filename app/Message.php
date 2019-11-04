<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

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

    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    public function childrenMessages()
    {   
        return $this->hasMany('App\Message', 'parent_id', 'id');
    }

    public function allChildrenMessages()
    {
        return $this->childrenMessages()->with('allChildrenMessages');
    }

    public function parent()
    {
        // recursively return all parents
        // the with() function call makes it recursive.
        // if you remove with() it only returns the direct parent
        return $this->belongsTo('App\Message', 'parent_id', 'id')->with('parent');
    }

    public function getRootParent()
    {
        if($this->parent)
        {
            return $this->parent->getRootParent();
        }

        return $this;
    }
}
