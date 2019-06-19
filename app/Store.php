<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
    	'title','image','is_active','is_featured','slug','link'
    ];

    public function coupon()
    {
        return $this->hasMany('App\Coupon');
    }
    public function category()
    {
        return $this->belongsToMany('App\CouponCategory');
    }
}
