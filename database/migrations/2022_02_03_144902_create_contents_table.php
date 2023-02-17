<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->integer('cate_id');
            $table->string('title');
            $table->string('alias');
            $table->text('intro')->nullable();
            $table->longtext('content')->nullable();
            $table->string('author')->nullable();
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->datetime('date_post')->nullable();
            $table->datetime('date_off')->nullable();
            $table->integer('view')->nullable()->default(0);
            $table->integer('hot')->nullable()->default(0);
            $table->integer('comment')->nullable()->default(0);
            $table->integer('order')->nullable()->default(0);
            $table->integer('status')->nullable()->default(0);
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
        Schema::dropIfExists('contents');
    }
}
