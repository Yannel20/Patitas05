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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id('ID_mascota');
            
            // Clave foránea corregida
            $table->unsignedBigInteger('ID_dueno')->nullable();
            $table->foreign('ID_dueno')
                  ->references('ID_dueno')
                  ->on('duenos')
                  ->onDelete('cascade');
            
            $table->string('n_registro')->unique();
            $table->string('nombre_m');
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->string('sexo', 1);
            $table->integer('edad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
