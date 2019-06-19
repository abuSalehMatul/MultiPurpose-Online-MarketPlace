<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;


class Coupon extends Model
{
  use Viewable;
  protected $fillable = [
  	'user_id','type','store_id','category_id','title','code','price','discount','expiry','detail','is_active','is_verified','is_featured','user_count','image','is_front','forum_category_id','slug','uni_id','link','rating','is_exclusive'
  ];

  // protected $dates = [
  //       'expiry' 
  //   ];
  public function category()
 	{
 		return $this->belongsTo('App\CouponCategory','category_id');
 	}
 	public function store()
 	{
 		return $this->belongsTo('App\Store');
 	}   	
 	public function user()
 	{
 		return $this->belongsTo('App\User');
 	} 	
	public function forumcategory()
 	{
 		return $this->belongsTo('App\ForumCategory','forum_category_id');
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
