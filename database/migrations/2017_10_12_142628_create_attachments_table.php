<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->comment('附件地址');
            $table->string('type')->nullable()->comment('附件类型');
            $table->string('name')->nullable()->comment('附件原始名称');
            $table->integer('size')->nullable()->comment('附件大小单位kb');
            $table->integer('note_id')->comment('所属笔记');
            $table->softDeletes();
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
        Schema::dropIfExists('attachments');
    }
}
