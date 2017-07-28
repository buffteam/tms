<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToUpdateLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('update_logs', function (Blueprint $table) {
            //
            $table->tinyInteger('type')->default(1)->comment('1表示日志2表示说明3表示计划');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('update_logs', function (Blueprint $table) {
            //
        });
    }
}
