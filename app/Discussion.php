<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;
use Auth;

class Discussion extends Model
{
  use Viewable;
 	protected $fillable = [
  	'user_id','forum_category_id','title','detail','is_active','is_featured','image','slug','uni_id','rating'
  ];
  
  public function getImageAttribute()
  {
    if (! $this->attributes['image']) {
      return 'default.png';
    }
    return $this->attributes['image'];
  }
	
	public function forumcategory()
 	{
 		return $this->belongsTo('App\ForumCategory','forum_category_id');
 	}	
  public function user()
 	{
 		return $this->belongsTo('App\User');
 	}
 	public function likes()
  {
    return $this->morphMany(Like::class, 'likeable');
  } 
  public function comments()
  {
    return $this->morphMany(Comment::class, 'commentable');
  }
  public function getIsLikedAttribute()
  {
    $like = $this->likes()->whereUserId(Auth::id())->first();
    return (!is_null($like)) ? $like->value : '0';
  }
}
