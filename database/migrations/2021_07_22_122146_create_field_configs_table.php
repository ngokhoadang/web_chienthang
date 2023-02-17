<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_configs', function (Blueprint $table) {
            $table->id();
            $table->string('themes');
            $table->string('pages');
            $table->string('field_type');
            $table->string('field_button_name')->nullable();
            $table->string('field_button_icon')->nullable();
            $table->string('field_button_class')->nullable();
            $table->string('field_button_action')->nullable();
            $table->string('field_button_type')->nullable();
            $table->string('field_button_js')->nullable();
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
        Schema::dropIfExists('field_configs');
    }
}
