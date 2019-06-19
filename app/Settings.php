<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
    	'logo','favicon','w_title','w_name','w_email','w_address','w_phone','w_time','f_title1','f_title2', 'f_title3','f_title4','footer_text','copyright','btn_title','btn_title2','btn_link2','btn_link','is_recent_deals','is_feat_slider','is_category_block','is_store_slider','m_text','is_mailchimp','is_playstore','is_app_icon','keywords','desc','is_blog','blog_layout','blog_left','footer_layout','footer_logo','preloader','currency','sidebar_abt','cuelink','is_gotop','is_preloader','right_click','inspect','app_link','playstore_link','navbar_img'
    ];
    public function getLogoAttribute()
		{
			if (! $this->attributes['logo']) {
				return 'logo.png';
			}
			return $this->attributes['logo'];
		}
		public function getFaviconAttribute()
		{
			if (! $this->attributes['favicon']) {
				return 'favicon_def.ico';
			}
			return $this->attributes['favicon'];
		}
		public function getBtnTitleAttribute()
		{
			if (! $this->attributes['btn_title']) {
				return 'Hot Deals';
			}
			return $this->attributes['btn_title'];
		}
		public function getBtnTitle2Attribute()
		{
			if (! $this->attributes['btn_title2']) {
				return 'Trending Items';
			}
			return $this->attributes['btn_title2'];
		}
		public function getFTitle1Attribute()
		{
			if (! $this->attributes['f_title1']) {
				return 'Widget 1';
			}
			return $this->attributes['f_title1'];
		}
		public function getFTitle2Attribute()
		{
			if (! $this->attributes['f_title2']) {
				return 'Widget 2';
			}
			return $this->attributes['f_title2'];
		}
		public function getFTitle3Attribute()
		{
			if (! $this->attributes['f_title3']) {
				return 'Widget 3';
			}
			return $this->attributes['f_title3'];
		}
		public function getFTitle4Attribute()
		{
			if (! $this->attributes['f_title4']) {
				return 'Newsletter Subscribe';
			}
			return $this->attributes['f_title4'];
		}
}
