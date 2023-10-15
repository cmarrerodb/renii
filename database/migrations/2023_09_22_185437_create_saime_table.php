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
        Schema::create('saime', function (Blueprint $table) {
            $table->char('nacionalidad', 1);
            $table->integer('cedula');
            $table->char('primer_apellido', 50);
            $table->char('segundo_apellido', 50);
            $table->char('primer_nombre', 50);
            $table->char('segundo_nombre', 50);
            $table->char('sexo', 1);
            $table->char('estado_civil', 1);
            $table->date('fecha_nacimiento');
            $table->increments('id');
        });

        // Crear los índices
        Schema::table('saime', function (Blueprint $table) {
            $table->index(['cedula'], 'idx_cedula');
            $table->index(['nacionalidad', 'cedula'], 'saime_nacionalidad_cedula');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saime');
    }
};
