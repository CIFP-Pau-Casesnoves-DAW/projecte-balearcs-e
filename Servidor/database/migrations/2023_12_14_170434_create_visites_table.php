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
        Schema::create('visites', function (Blueprint $table) {
            $table->id();
            $table->string('titol');
            $table->text('descripcio');
            $table->boolean('inscripcio_previa')->default(false);
            $table->integer('n_places');
            $table->integer('total_visitants')->nullable();
            $table->date('data_inici');
            $table->date('data_fi');
            $table->string('horari');
            $table->date('data_baixa')->nullable();
            $table->foreignId('espai_id')->constrained('espais')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
