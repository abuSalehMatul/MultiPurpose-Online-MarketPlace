<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('w_name')->nullable();
            $table->string('w_title')->nullable();
            $table->string('w_email')->nullable();
            $table->string('w_address')->nullable();
            $table->string('w_phone')->nullable();
            $table->string('w_time')->nullable();
            $table->text('keywords')->nullable();
            $table->text('desc')->nullable();
            $table->string('navbar_img')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('btn_title')->nullable();
            $table->string('btn_link')->nullable();
            $table->string('btn_title2')->nullable();
            $table->string('btn_link2')->nullable();
            $table->boolean('is_feat_slider')->default(1);
            $table->boolean('is_recent_deals')->default(1);
            $table->boolean('is_category_block')->default(1);
            $table->boolean('is_store_slider')->default(1);
            $table->string('f_title1')->nullable();
            $table->string('f_title2')->nullable();
            $table->string('f_title3')->nullable();
            $table->string('f_title4')->nullable();
            $table->string('footer_text')->nullable();
            $table->string('copyright')->nullable();
            $table->boolean('is_mailchimp')->default(1);
            $table->string('m_text')->nullable();
            $table->boolean('is_app_icon')->default(1);
            $table->boolean('is_playstore')->default(1);
            $table->boolean('is_blog')->default(1);
            $table->boolean('blog_layout')->default(0);
            $table->boolean('blog_left')->default(1);
            $table->boolean('footer_layout')->default(0);
            $table->string('preloader')->nullable();
            $table->string('footer_logo')->nullable();
            $table->string('currency')->nullable();
            $table->string('cuelink')->nullable();
            $table->text('sidebar_abt')->nullable();
            $table->boolean('is_preloader')->default(1);
            $table->boolean('is_gotop')->default(1);
            $table->boolean('right_click')->default(0);
            $table->boolean('inspect')->default(0);
            $table->string('app_link')->nullable();
            $table->string('playstore_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
