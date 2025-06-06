<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Temos o ID sendo usado para FK, pois o uuid para relações pode deixar o JOIN mais lento
     *  O UUID será exposto publicamente, evitando que o id sequencial fique visivel
     *
     * Os campos de coordenadas, se for usado para algum tipo de cálculo, acho que o decimal não é o ideal, talvez o geometry
     *
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipient_addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('recipient_id')->constrained('recipients')->onDelete('cascade');
            $table->string('street');
            $table->string('state');
            $table->string('zip_code', 10);
            $table->string('country');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipient_addresses');
    }
};
