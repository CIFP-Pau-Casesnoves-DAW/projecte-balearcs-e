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
        Schema::create('espais', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('descripcio');
            $table->string('carrer');
            $table->string('numero');
            $table->string('pis_porta')->nullable();
            $table->string('web')->nullable();
            $table->string('mail');
            $table->enum('grau_acc', ['baix', 'mig', 'alt'])->nullable()->default(null);
            $table->date('data_baixa')->nullable();
            $table->foreignId('arquitecte_id')->constrained('arquitectes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('gestor_id')->constrained('usuaris')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('tipus_id')->constrained('tipus')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('municipi_id')->constrained('municipis')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espais');
    }
};
