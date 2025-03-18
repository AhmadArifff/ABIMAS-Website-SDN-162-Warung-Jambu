<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTautanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tautan', function (Blueprint $table) {
            $table->bigIncrements('tt_id');
            $table->unsignedBigInteger('tt_create_id')->index();
            $table->unsignedBigInteger('tt_update_id')->nullable();
            $table->unsignedBigInteger('tt_delete_id')->nullable();
            $table->string('tt_nama_tautan', 255);
            $table->text('tt_url');
            $table->timestamp('tt_create_at')->useCurrent();
            $table->timestamp('tt_update_at')->useCurrent()->nullable();
            $table->timestamp('tt_delete_at')->nullable();
            $table->foreign('tt_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('tt_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('tt_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tautan');
    }
}
