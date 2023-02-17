<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_configs', function (Blueprint $table) {
            $table->id();
			$table->string('web_name');
			$table->string('web_url');
			$table->string('web_folder');
			$table->text('web_logo')->nullabel();
			$table->string('web_hotline')->nullabel();
			$table->text('web_keyword')->nullabel();
			$table->text('web_description')->nullabel();
			$table->text('web_contact')->nullabel();
			$table->text('web_info')->nullabel();
			$table->text('web_copyright')->nullabel();
			$table->string('language')->nullabel();
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
        Schema::dropIfExists('web_configs');
    }
}
