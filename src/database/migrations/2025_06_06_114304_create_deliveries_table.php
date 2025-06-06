<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     *
     * Temos o ID sendo usado para FK, pois o uuid para relações pode deixar o JOIN mais lento
     *   O UUID será exposto publicamente, evitando que o id sequencial fique visivel
     *
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->integer('volumes');

            $table->foreignId('carrier_id')->constrained('carriers');
            $table->foreignId('sender_id')->constrained('senders');
            $table->foreignId('recipient_id')->constrained('recipients');

            $table->foreignId('recipient_address_id')->constrained('recipient_addresses');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
