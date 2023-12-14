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
        Schema::create('visites_punts_interes', function (Blueprint $table) {
            $table->foreignId('punts_interes_id')->constrained('punts_interes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('visita_id')->constrained('visites')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('ordre');
            $table->date('data_baixa')->nullable();
            $table->primary(['punts_interes_id', 'visita_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites_punts_interes');
    }
};
