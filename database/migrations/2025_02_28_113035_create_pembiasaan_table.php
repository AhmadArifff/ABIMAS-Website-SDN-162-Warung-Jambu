<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembiasaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembiasaan', function (Blueprint $table) {
            $table->bigIncrements('p_id');
            $table->unsignedBigInteger('k_id')->index();
            $table->unsignedBigInteger('p_create_id')->index();
            $table->unsignedBigInteger('p_update_id')->nullable();
            $table->unsignedBigInteger('p_delete_id')->nullable();
            $table->string('p_nama_kegiatan', 255);
            $table->text('p_deskripsi');
            $table->string('p_foto', 255)->nullable();
            $table->enum('p_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('p_create_at')->useCurrent();
            $table->timestamp('p_update_at')->useCurrent()->nullable();
            $table->timestamp('p_delete_at')->nullable();
            $table->foreign('k_id')->references('k_id')->on('kesiswaan')->onDelete('restrict');
            $table->foreign('p_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('p_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('p_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembiasaan');
    }
}
