<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnFdetailFrontendToFieldDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('field_details', function (Blueprint $table) {
            $table->integer('fdetail_frontend')->after('fdetail_multiple')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('field_details', function (Blueprint $table) {
            $table->dropColumn('fdetail_frontend');
        });
    }
}
