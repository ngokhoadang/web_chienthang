<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_details', function (Blueprint $table) {
            $table->id();
            $table->string('themes');
            $table->string('pages');
            $table->string('fdetail_label');
            $table->string('fdetail_label');
            $table->string('fdetail_name');
            $table->string('fdetail_type');
            $table->string('fdetail_description')->nullable();
            $table->string('fdetail_placeholder')->nullable();
            $table->string('fdetail_required')->nullable();
            $table->string('fdetail_url')->nullable(); // root or link using for multiple selection
            $table->string('fdetail_modules')->nullable(); // name module get data | config url: root/admin/{modules}/list-json
            $table->string('fdetail_multiple')->nullable(); // 1: yes, 0: no
            $table->string('fdetail_status')->nullable()->default(0);
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
        Schema::dropIfExists('field_details');
    }
}
