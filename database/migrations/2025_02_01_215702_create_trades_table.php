<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['buy_up', 'buy_down']);
            $table->integer('duration'); // 180, 150, 90 seconds
            $table->decimal('btc_price', 15, 8);
            $table->timestamp('trade_start')->useCurrent();
            $table->timestamp('trade_end')->nullable();
            $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
