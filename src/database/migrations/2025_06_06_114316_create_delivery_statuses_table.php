<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Temos o ID sendo usado para FK, pois o uuid para relações pode deixar o JOIN mais lento
     *    O UUID será exposto publicamente, evitando que o id sequencial fique visivel
     *
     * Acho que o ideal seria ter um ENUM de possíveis status
     *
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_statuses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('delivery_id')->constrained('deliveries')->onDelete('cascade');
            $table->string('message');
            $table->timestamp('event_timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_statuses');
    }
};
