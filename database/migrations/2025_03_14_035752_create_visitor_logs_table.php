<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('visitor_logs', function (Blueprint $table) {
        //     $table->bigIncrements('v_id');
        //     $table->string('v_ip_address');
        //     $table->string('v_user_agent');
        //     $table->string('v_referer')->nullable();
        //     $table->string('v_url');
        //     $table->timestamp('v_visited_at')->useCurrent();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('visitor_logs');
    }
}
