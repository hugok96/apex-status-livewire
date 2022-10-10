<?php

use App\Models\MapRotation;
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
        Schema::create('game_modes', function (Blueprint $table) {
            $table->id();
            $table->string('api_id');
            $table->string('name');
            $table->foreignIdFor(MapRotation::class, 'current_rotation_id')->nullable();
            $table->foreignIdFor(MapRotation::class, 'next_rotation_id')->nullable();
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
        Schema::dropIfExists('game_modes');
    }
};
