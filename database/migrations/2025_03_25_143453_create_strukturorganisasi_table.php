<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrukturorganisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strukturorganisasi', function (Blueprint $table) {
            $table->bigIncrements('so_id');
            $table->unsignedBigInteger('so_create_id')->index();
            $table->unsignedBigInteger('so_update_id')->nullable();
            $table->unsignedBigInteger('so_delete_id')->nullable();
            $table->string('so_judul_slide', 255);
            $table->string('so_deskripsi_slide', 255);
            $table->string('so_foto_slide', 255)->nullable();
            $table->string('so_judul_content', 255);
            $table->text('so_deskripsi');
            $table->string('so_foto_atau_pdf', 255)->nullable();
            $table->enum('so_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('so_create_at')->useCurrent();
            $table->timestamp('so_update_at')->useCurrent()->nullable();
            $table->timestamp('so_delete_at')->nullable();
            $table->foreign('so_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('so_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('so_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('strukturorganisasi');
    }
}
