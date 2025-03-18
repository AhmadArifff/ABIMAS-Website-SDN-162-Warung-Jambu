<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenghargaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penghargaan', function (Blueprint $table) {
            $table->bigIncrements('ph_id');
            $table->unsignedBigInteger('k_id')->index();
            $table->unsignedBigInteger('e_id')->index();
            $table->unsignedBigInteger('ph_create_id')->index();
            $table->unsignedBigInteger('ph_update_id')->nullable();
            $table->unsignedBigInteger('ph_delete_id')->nullable();
            $table->string('ph_nama_kegiatan', 255);
            $table->text('ph_deskripsi');
            $table->string('ph_foto', 255)->nullable();
            $table->enum('ph_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('ph_create_at')->useCurrent();
            $table->timestamp('ph_update_at')->useCurrent()->nullable();
            $table->timestamp('ph_delete_at')->nullable();
            $table->foreign('k_id')->references('k_id')->on('kesiswaan')->onDelete('restrict');
            $table->foreign('e_id')->references('e_id')->on('ekstrakurikuler')->onDelete('restrict');
            $table->foreign('ph_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('ph_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('ph_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penghargaan');
    }
}
