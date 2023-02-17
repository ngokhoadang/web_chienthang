<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayoutConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('layout_id');
            $table->integer('widget_id');
            $table->string('content_column')->nullable()->default(NULL);
            $table->string('modules')->nullable()->default(NULL); //Dùng module -> Set table -> get data form database
            $table->string('type')->nullable()->default(NULL);//Get data from widget or column
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
        Schema::dropIfExists('layout_configs');
    }
}
