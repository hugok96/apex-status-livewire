<?php

use App\Models\CraftingRotation;
use App\Models\ItemType;
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
        Schema::create('item_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->integer('cost');
            $table->foreignIdFor(CraftingRotation::class, 'crafting_rotation_id');
            $table->foreignIdFor(ItemType::class, 'item_type_id');
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
        Schema::dropIfExists('item_definitions');
    }
};
