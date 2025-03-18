<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEkstrakurikulerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->bigIncrements('e_id');
            // $table->unsignedBigInteger('k_id')->index();
            $table->unsignedBigInteger('e_create_id')->index();
            $table->unsignedBigInteger('e_update_id')->nullable();
            $table->unsignedBigInteger('e_delete_id')->nullable();
            $table->string('e_judul_slide', 255);
            $table->string('e_deskripsi_slide', 255);
            $table->string('e_foto_slide1', 255)->nullable();
            $table->string('e_foto_slide2', 255)->nullable();
            $table->string('e_foto_slide3', 255)->nullable();
            $table->string('e_nama_ekstrakurikuler', 255);
            $table->text('e_deskripsi');
            $table->string('e_foto', 255)->nullable();
            $table->enum('e_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('e_create_at')->useCurrent();
            $table->timestamp('e_update_at')->useCurrent()->nullable();
            $table->timestamp('e_delete_at')->nullable();
            // $table->foreign('k_id')->references('k_id')->on('kesiswaan')->onDelete('restrict');
            $table->foreign('e_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('e_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('e_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ekstrakurikuler');
    }
}
