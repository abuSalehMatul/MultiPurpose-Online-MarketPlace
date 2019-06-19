<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
  	protected $fillable = [
    	'title','is_active','slug'
    ];

    public function faq()
    {
        return $this->hasMany('App\Faq');
    }
}
