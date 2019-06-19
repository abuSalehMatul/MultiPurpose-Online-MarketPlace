<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('coupons', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('store_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->string('type')->nullable();
			$table->integer('forum_category_id')->unsigned();
			$table->string('uni_id')->unique();
			$table->string('slug')->nullable();
			$table->string('title')->nullable(); 
			$table->string('code')->nullable();
			$table->integer('price')->nullable();
			$table->integer('discount')->nullable();
			$table->string('link')->nullable();
			$table->date('expiry')->nullable();
			$table->integer('rating')->default(0);
			$table->text('detail')->nullable();
			$table->string('image')->nullable();
			$table->integer('user_count')->default(0);
			$table->boolean('is_featured')->default(0);
			$table->boolean('is_exclusive')->default(1);
			$table->boolean('is_front')->default(1);
			$table->boolean('is_active')->default(1);
			$table->boolean('is_verified')->default(0);
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
      $table->foreign('category_id')->references('id')->on('coupon_categories')->onDelete('cascade');
      $table->foreign('forum_category_id')->references('id')->on('forum_categories')->onDelete('cascade');
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
		Schema::dropIfExists('coupons');
	}
}
