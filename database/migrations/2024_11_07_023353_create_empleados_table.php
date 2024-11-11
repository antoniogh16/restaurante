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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100); // Nombre del empleado
            $table->string('duration', 100); // Duración del empleo o contrato
            $table->text('description'); // Descripción larga, sin límite de caracteres en tipo text
            $table->string('mode', 50); // Modo de trabajo (por ejemplo, remoto o presencial)
            $table->date('start_date'); // Fecha de inicio del contrato o empleo
            $table->date('finish_date'); // Fecha de finalización del contrato o empleo
            $table->decimal('cost', 10, 2); // Costo o salario, con dos decimales
            $table->string('image', 255); // URL o ruta de la imagen del empleado, con longitud ampliada a 255
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
