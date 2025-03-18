<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaSosialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_sosial', function (Blueprint $table) {
            $table->bigIncrements('ms_id');
            $table->unsignedBigInteger('ms_create_id')->index();
            $table->unsignedBigInteger('ms_update_id')->nullable();
            $table->unsignedBigInteger('ms_delete_id')->nullable();
            $table->string('ms_nama_media', 255);
            $table->text('ms_url');
            $table->timestamp('ms_create_at')->useCurrent();
            $table->timestamp('ms_update_at')->useCurrent()->nullable();
            $table->timestamp('ms_delete_at')->nullable();
            $table->foreign('ms_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('ms_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('ms_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_sosial');
    }
}
