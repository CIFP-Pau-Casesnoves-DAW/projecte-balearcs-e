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
        Schema::create('espais_serveis', function (Blueprint $table) {
            $table->foreignId('servei_id')->constrained('serveis')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('espai_id')->constrained('espais')->onUpdate('cascade')->onDelete('restrict');
            $table->primary(['servei_id', 'espai_id']);
            $table->timestamps();
            $table->date('data_baixa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espais_serveis');
    }
};
