<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnCateIdToArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('cate_id')->after('id');
            $table->string('art_intro')->after('art_alias')->nullable();
            $table->string('art_image')->after('art_intro')->nullable();
            $table->string('art_hot')->after('art_order')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('cate_id');
            $table->dropColumn('art_intro');
            $table->dropColumn('art_image');
            $table->dropColumn('art_hot');
        });
    }
}
