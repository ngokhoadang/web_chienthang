<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title');
            $table->string('page_modules'); // modules: products, contents, contact
            $table->string('page_pages'); // pages: NULL, detail
            $table->string('page_keyword'); // keywords: products || productsdetail, contents || contentsdetails
            $table->string('page_type'); // pages: contents, products or modules: banners,... (show modules in pages)
            $table->integer('page_status')->nullable()->default(0);
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
        Schema::dropIfExists('pages');
    }
}
