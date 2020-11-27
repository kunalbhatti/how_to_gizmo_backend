<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('article_id')->nullable();
            $table->string('question');
            $table->text('answer')->nullable();
            $table->text('html')->nullable();
            $table->text('css')->nullable();
            $table->text('frontend')->nullable();
            $table->text('backend')->nullable();
            $table->text('database')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     */
    public function down()
    {
        Schema::dropIfExists('archives');
    }
}
