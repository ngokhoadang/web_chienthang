<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('perdetail_modules');
            $table->text('perdetail_permission')->nullable();
            $table->string('perdetail_type')->nullable();
            $table->integer('perdetail_sort')->nullable()->detail(0);
            $table->integer('perdetail_status')->nullable()->detail(0);
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
        Schema::dropIfExists('permission_details');
    }
}
