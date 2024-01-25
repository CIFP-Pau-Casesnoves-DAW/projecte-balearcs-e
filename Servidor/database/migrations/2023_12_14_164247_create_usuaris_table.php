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
        Schema::create('usuaris', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('llinatges');
            $table->string('dni');
            $table->string('mail');
            $table->string('contrasenya');
            $table->enum('rol', ['usuari', 'administrador', 'gestor'])->default('usuari');
            $table->date('data_baixa')->nullable();
            $table->timestamps();
        });
    }

    
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuaris');
    }
};
