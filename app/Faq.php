<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
    	'faq_category_id',
    	'question',
    	'answer',
    	'like',
    	'dislike'
    ];

    public function faqcategory()
    {
    	return $this->belongsTo('App\FaqCategory','faq_category_id');
    }
}
