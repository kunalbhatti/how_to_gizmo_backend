<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnippetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snippets', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('name');
            $table->string('status');
            $table->text('image');
            $table->text('description');
            $table->text('content')->nullable();
            $table->string('backend')->nullable();
            $table->string('frontend')->nullable();
            $table->string('database')->nullable();
            $table->string('libraries')->nullable();
            $table->text('git')->nullable();
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
        Schema::dropIfExists('snippets');
    }
}
