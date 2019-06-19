<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table ="article_sub_categories";
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Model\Mining','category_id','id');
    }

    public function posts()
    {
        return $this->hasMany('App\Model\PricingPlan','subcategory_id');
    }
}
