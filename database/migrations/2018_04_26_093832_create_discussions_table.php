d<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('forum_category_id')->unsigned();
            $table->string('uni_id')->unique();
            $table->string('slug')->nullable();
            $table->string('title')->nullable(); 
            $table->text('detail')->nullable();
            $table->integer('rating')->default(0);
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(1);
            $table->boolean('is_active')->default(1);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('discussions');
    }
}
