<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "learn_categories";

    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany('App\Model\Post','cat_id');
    }
}
