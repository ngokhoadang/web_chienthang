<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key');//article:title
            $table->string('name');//Tiêu đề bài viết
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
        Schema::table('language_keys', function (Blueprint $table) {
            Schema::dropIfExists('language_keys');
        });
    }
}
