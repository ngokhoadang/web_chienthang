<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFillableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fillable', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->text('table_fillable'); //Tất cả các trường của bảng
            $table->text('table_get')->nullable(); //Trường hiển thị danh sách
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
        Schema::dropIfExists('fillable');
    }
}
