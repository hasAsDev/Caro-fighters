<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('battlegrounds', function (Blueprint $table) {
            $table->ulid('battleground_id');
            $table->integer('fighter_X');
            $table->integer('fighter_O');
            $table->integer('winner'); // -1:null 0:draw :winner
            $table->string('turn', length: 1); // "X" "O 
            $table->string('battle_record', length: 1000);
            $table->integer('X_timer');
            $table->integer('O_timer');
            $table->integer('time_point');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battlegrounds');
    }
};
