<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponPages extends Model
{
  protected $fillable = [
  	'title','slug','body','widget'
  ];
}
