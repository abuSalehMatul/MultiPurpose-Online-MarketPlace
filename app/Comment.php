<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [
		'body','user_id','is_active'
	];
  public function commentable()
  {
      return $this->morphTo();
  }
  public function replies()
  {
    return $this->hasMany('App\Comment','reply_id');
  }
  public function users()
  {
    return $this->belongsTo('App\User','user_id');
  }
}
