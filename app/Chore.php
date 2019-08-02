<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;

class Chore extends Model implements ViewableContract
{
    use Viewable;
    protected $removeViewsOnDelete = true;
    public function category(){
        return $this->belongsTo('App\ChoreCategory','category_id');
    }
    public function user(){
        return $this->belongsTo('App\User','creator');
    }
}
