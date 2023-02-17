<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('cate_title');
            $table->integer('category');
            $table->string('cate_alias');
            $table->string('cate_url');
            $table->string('cate_url_extent');
            $table->text('cate_intro');
            $table->text('cate_keywords');
            $table->text('cate_description');
            $table->string('cate_modules');
            $table->string('cate_by');
            $table->integer('cate_view');
            $table->integer('cate_mainmenu');
            $table->integer('cate_submenu');
            $table->integer('cate_order');
            $table->integer('cate_status');
            $table->string('language');
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
        Schema::dropIfExists('categories');
    }
}
