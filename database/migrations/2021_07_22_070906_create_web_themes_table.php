<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('folder');
            $table->string('favicon_ico')->nullable();
            $table->integer('status')->nullable()->default(0);
            $table->integer('enable')->nullable()->default(0);
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
        Schema::dropIfExists('web_themes');
    }
}
