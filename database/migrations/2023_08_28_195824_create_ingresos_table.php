<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->id();
            $table->integer('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->timestamp('fecha_ingreso');
            $table->string('token',100);
            $table->smallInteger('status_ingreso')->default(1);
            $table->timestamp('fecha_salida')->nullable();
            $table->smallInteger('status_salida')->nullable();            
            $table->timestamps();
        });
        DB::statement('ALTER TABLE ingresos ADD ip inet');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingresos', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropColumn(['ip']);
        });         
        Schema::dropIfExists('ingresos');
    }
};
