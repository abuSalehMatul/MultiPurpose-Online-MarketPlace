<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  protected $fillable = [
  	'title','desc','user_id','slug','uni_id','is_active','image'
  ];

	public function tags()
	{
	   return $this->belongsToMany('App\Tag');
	}	
  public function comments()
  {
    return $this->morphMany(Comment::class, 'commentable');
  }
  public function users()
  {
		return $this->belongsTo('App\User','user_id');
  }
}
