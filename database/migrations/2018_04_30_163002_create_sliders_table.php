<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_image')->default(1);
            $table->string('title')->nullable();
            $table->string('heading')->nullable();
            $table->string('subheading')->nullable();
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_overlay')->default(1);
            $table->boolean('is_parallax')->default(1);
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('sliders');
    }
}
