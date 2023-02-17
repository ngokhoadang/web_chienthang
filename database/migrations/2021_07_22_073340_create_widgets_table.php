<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('widget_title');
            $table->string('widget_module');
            $table->longtext('widget_content')->nullable();
            $table->integer('widget_type')->nullable();
            $table->integer('widget_qty')->nullable();
            $table->longtext('widget_style')->nullable();
            $table->string('widget_state')->nullable();
            $table->text('widget_info')->nullable();
            $table->text('widget_by')->nullable();
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
        Schema::dropIfExists('widgets');
    }
}
