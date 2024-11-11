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
        Schema::create('empleados_restaurantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('restaurante_id');
            
            // Relación con empleados
            $table->foreign('empleado_id')->references('id')->on('empleados')
                ->onDelete('cascade');
            
            // Relación con restaurantes
            $table->foreign('restaurante_id')->references('id')->on('restaurantes')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados_restaurantes'); // Cambié el nombre a 'empleados_restaurantes'
    }
};
