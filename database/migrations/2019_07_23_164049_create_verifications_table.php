<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('question')->nullable();
            $table->text('answer')->nullable();
            $table->string('personal_image')->nullable();
            $table->string('document_image')->nullable();
            $table->string('id_image')->nullable();
            $table->string('certification')->nullable();
            $table->string('licence')->nullable();
            $table->string('pin')->nullable();
            $table->string('as_role')->nullable();
            $table->string('ip')->default('0.0.0.0');
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
        Schema::dropIfExists('verifications');
    }
}
