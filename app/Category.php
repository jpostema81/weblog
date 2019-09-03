<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // these attributes are mass-assignable
    protected $fillable = [
        'name'
    ];
    
    public function messages()
    {
        return $this->belongsToMany('App\Message');
    }
}
