<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
    	'is_image','is_parallax','is_overlay','is_active','title','heading','subheading','link','image'
    ];
}
