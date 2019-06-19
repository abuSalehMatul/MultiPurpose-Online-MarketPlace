<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $guarded =[];

    public function category()
    {
        return $this->belongsTo( 'App\Model\Category','cat_id');
    }
}
