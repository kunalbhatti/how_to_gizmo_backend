<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('status');
            $table->text('image');
            $table->text('description');
            $table->text('content');
            $table->string('backend')->nullable();
            $table->string('frontend')->nullable();
            $table->string('database')->nullable();
            $table->string('libraries')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
