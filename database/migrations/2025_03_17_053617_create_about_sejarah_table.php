<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutSejarahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_sejarah', function (Blueprint $table) {
            $table->bigIncrements('as_id');
            $table->unsignedBigInteger('k_id')->index();
            $table->unsignedBigInteger('as_create_id')->index();
            $table->unsignedBigInteger('as_update_id')->nullable();
            $table->unsignedBigInteger('as_delete_id')->nullable();
            $table->text('as_sejarah');
            $table->timestamp('as_create_at')->useCurrent();
            $table->timestamp('as_update_at')->useCurrent()->nullable();
            $table->timestamp('as_delete_at')->nullable();
            $table->foreign('k_id')->references('k_id')->on('kesiswaan')->onDelete('restrict');
            $table->foreign('as_create_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('as_update_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('as_delete_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about_sejarah');
    }
}
