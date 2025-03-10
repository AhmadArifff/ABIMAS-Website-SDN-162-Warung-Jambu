<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKesiswaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kesiswaan', function (Blueprint $table) {
            $table->bigIncrements('k_id');
            $table->unsignedBigInteger('k_create_id')->index();
            $table->unsignedBigInteger('k_update_id')->nullable();
            $table->unsignedBigInteger('k_delete_id')->nullable();
            $table->string('k_nama_menu', 255);
            $table->string('k_judul_slide', 255);
            $table->string('k_deskripsi_slide', 255);
            $table->string('k_judul_isi_content', 255);
            $table->string('k_foto_slide1', 255)->nullable();
            $table->string('k_foto_slide2', 255)->nullable();
            $table->string('k_foto_slide3', 255)->nullable();
            $table->enum('k_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('k_create_at')->useCurrent();
            $table->timestamp('k_update_at')->useCurrent()->nullable();
            $table->timestamp('k_delete_at')->nullable();
            $table->foreign('k_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('k_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('k_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kesiswaan');
    }
}
