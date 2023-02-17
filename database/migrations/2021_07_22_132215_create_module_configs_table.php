<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_configs', function (Blueprint $table) {
            $table->id();
            $table->string('pages');
            $table->string('name');
            $table->longtext('key_modules');
            $table->text('key_buttons')->nullable();
            $table->integer('page_length')->nullable()->default(0);
            $table->text('order_by')->nullable();
            $table->integer('search_box')->nullable()->default(0);
            $table->integer('show_paging')->nullable()->default(0);
            $table->text('total_modules')->nullable();
            $table->text('fixed_modules')->nullable();
            $table->integer('module_status')->nullable()->default(0);
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
        Schema::dropIfExists('module_configs');
    }
}
