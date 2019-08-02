<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChoreCategory extends Model
{
   public function chore(){
       return $this->hasMany('App\Chore','category_id');
   }
}
