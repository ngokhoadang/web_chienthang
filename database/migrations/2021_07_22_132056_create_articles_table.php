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
            $table->id();
            $table->string('themes');
            $table->string('pages');
            $table->string('art_title');
            $table->string('art_alias');
            $table->date('art_date_post');
            $table->date('art_date_end')->nullable();
            $table->string('art_created_by')->nullable();
            $table->integer('art_view')->nullable()->default(0);
            $table->integer('art_comment')->nullable()->default(0);
            $table->integer('art_order')->nullable()->default(0);
            $table->integer('art_status')->nullable()->default(0);
            $table->string('language')->nullable();
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
