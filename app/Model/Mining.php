<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mining extends Model
{
    protected $table ="article_categories";
    protected $guarded = [];


    public function subcategory()
    {
        return $this->hasMany( 'App\Model\Unit','category_id');
    }

}
