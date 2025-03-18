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
<<<<<<< HEAD
            $table->enum('b_foto', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
=======
            $table->string('b_foto', 255)->nullable();
            $table->enum('b_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
>>>>>>> be8b2b83b87cf522a1c98946187e9b334ddac469
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
