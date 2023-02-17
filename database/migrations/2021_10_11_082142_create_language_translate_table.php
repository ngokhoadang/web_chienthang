<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageTranslateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_translates', function (Blueprint $table) {
            $table->id();
            $table->string('language_key');//article:title
            $table->string('translate_name');//Tiêu đề bài viết
            $table->string('translate_language');//Tiêu đề bài viết
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
        Schema::table('language_translates', function (Blueprint $table) {
            Schema::dropIfExists('language_translates');
        });
    }
}
