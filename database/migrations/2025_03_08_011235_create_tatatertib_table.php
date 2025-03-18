<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTatatertibTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tatatertib', function (Blueprint $table) {
            $table->bigIncrements('t_id');
            $table->unsignedBigInteger('k_id')->index();
            $table->unsignedBigInteger('t_create_id')->index();
            $table->unsignedBigInteger('t_update_id')->nullable();
            $table->unsignedBigInteger('t_delete_id')->nullable();
            $table->string('t_nama_peraturan', 255);
            $table->text('t_deskripsi');
            $table->enum('t_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('t_create_at')->useCurrent();
            $table->timestamp('t_update_at')->useCurrent()->nullable();
            $table->timestamp('t_delete_at')->nullable();
            $table->foreign('k_id')->references('k_id')->on('kesiswaan')->onDelete('restrict');
            $table->foreign('t_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('t_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('t_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tatatertib');
    }
}
