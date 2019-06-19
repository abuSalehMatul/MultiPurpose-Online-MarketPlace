<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $table ="articles";
    protected  $guarded = [];


    public function category()
    {
        return $this->belongsTo('App\Model\Mining','category_id','id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Model\Unit','subcategory_id','id');
    }

}
