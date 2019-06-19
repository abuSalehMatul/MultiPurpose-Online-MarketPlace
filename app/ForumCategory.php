<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $fillable = [
    	'category','title','detail','is_active','slug'
    ];
    
  public function discussion()
  {
      return $this->hasMany('App\Discussion');
  }
   public function coupon()
  {
      return $this->hasMany('App\Coupon');
  }
}
