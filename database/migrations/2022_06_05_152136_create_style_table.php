<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_styles', function (Blueprint $table) {
            $table->id();
            $table->string('style_name');
            $table->string('style_note')->nullable();
            $table->string('style_file')->nullable(); //Để lúc quản trị set thì ko cần phải cập nhật, để cho thành viên cập nhật
            $table->string('style_access');
            $table->string('style_created');
            $table->string('style_author');
            $table->string('style_status')->nullable()->default(0);
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
        Schema::dropIfExists('web_styles');
    }
}
