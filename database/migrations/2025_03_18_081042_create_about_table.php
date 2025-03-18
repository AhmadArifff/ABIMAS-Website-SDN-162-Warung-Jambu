<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about', function (Blueprint $table) {
            $table->bigIncrements('a_id');
            $table->unsignedBigInteger('as_id')->index();
            $table->unsignedBigInteger('k_id')->index();
            $table->unsignedBigInteger('a_create_id')->index();
            $table->unsignedBigInteger('a_update_id')->nullable();
            $table->unsignedBigInteger('a_delete_id')->nullable();
            $table->string('a_visi', 255);
            $table->string('a_misi', 255);
            $table->enum('a_status', ['PUBLISH', 'DRAFT', 'HAPUS', 'TIDAK']);
            $table->timestamp('a_create_at')->useCurrent();
            $table->timestamp('a_update_at')->useCurrent()->nullable();
            $table->timestamp('a_delete_at')->nullable();
            $table->foreign('k_id')->references('k_id')->on('kesiswaan')->onDelete('restrict');
            $table->foreign('as_id')->references('as_id')->on('about_sejarah')->onDelete('restrict');
            $table->foreign('a_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('a_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('a_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about');
    }
}
