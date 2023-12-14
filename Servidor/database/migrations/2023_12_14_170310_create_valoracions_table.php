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
        Schema::create('valoracions', function (Blueprint $table) {
            $table->id();
            $table->integer('puntuacio');
            $table->date('data');
            $table->date('data_baixa')->nullable();
            $table->foreignId('usuari_id')->constrained('usuaris')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('espai_id')->constrained('espais')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valoracions');
    }
};
