<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->bigIncrements('b_id');
            $table->unsignedBigInteger('k_id')->index();
            $table->unsignedBigInteger('b_create_id')->index();
            $table->unsignedBigInteger('b_update_id')->nullable();
            $table->unsignedBigInteger('b_delete_id')->nullable();
            $table->string('b_nama_kegiatan', 255);
            $table->text('b_deskripsi');
            $table->enum('b_foto', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('b_create_at')->useCurrent();
            $table->timestamp('b_update_at')->useCurrent()->nullable();
            $table->timestamp('b_delete_at')->nullable();
            $table->foreign('k_id')->references('k_id')->on('kesiswaan')->onDelete('restrict');
            $table->foreign('b_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('b_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('b_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berita');
    }
}
