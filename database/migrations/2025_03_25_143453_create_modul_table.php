<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modul', function (Blueprint $table) {
            $table->bigIncrements('m_id');
            $table->unsignedBigInteger('m_create_id')->index();
            $table->unsignedBigInteger('m_update_id')->nullable();
            $table->unsignedBigInteger('m_delete_id')->nullable();
            $table->unsignedBigInteger('m_guru_id')->nullable();
            $table->string('m_nama_modul', 255);
            $table->string('m_modul_kelas', 255);
            $table->text('m_deskripsi_modul');
            $table->string('m_foto_atau_pdf', 255)->nullable();
            $table->enum('m_status', ['PUBLISH', 'DRAFT', 'HAPUS']);
            $table->timestamp('m_create_at')->useCurrent();
            $table->timestamp('m_update_at')->useCurrent()->nullable();
            $table->timestamp('m_delete_at')->nullable();
            $table->foreign('m_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('m_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('m_delete_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('m_guru_id')->references('id')->on('gurus')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modul');
    }
}
