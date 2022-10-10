<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('server_type');
            $table->string('server_region');
            $table->integer('status_code');
            $table->dateTime('query_dt');
            $table->integer('response_time');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('server_statuses');
    }
};
