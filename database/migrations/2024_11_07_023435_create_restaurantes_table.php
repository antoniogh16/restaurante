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
        Schema::create('restaurantes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80); // Nombre del restaurante
            $table->string('last_name', 80); // Otra información del restaurante, tal vez del propietario o administrador
            $table->foreignId('country_id')->constrained('countries')
                ->onUpdate('cascade')
                ->onDelete('restrict'); // Relación con la tabla 'countries'
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurantes'); // Asegúrate de eliminar la tabla 'restaurantes'
    }
};
