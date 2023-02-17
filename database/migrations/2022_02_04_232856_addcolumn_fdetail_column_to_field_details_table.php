<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddcolumnFdetailColumnToFieldDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('field_details', function (Blueprint $table) {
            $table->string('fdetail_column')->after('fdetail_type')->nullable()->default('left');
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
            $table->dropColumn('fdetail_column');
        });
    }
}
