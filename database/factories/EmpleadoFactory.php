<?php

namespace Database\Factories;

use App\Models\Empleado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    protected $model = Empleado::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $empleadoRoles = [
            'Chef de Cocina',
            'Camarero',
            'Recepcionista',
            'Gerente de Restaurante',
            'Cocinero',
            'Ayudante de Cocina',
            'Sommelier',
            'Bartender',
            'Supervisor de Sala',
            'Encargado de Limpieza'
        ];

        return [
            'name' => $this->faker->randomElement($empleadoRoles),
            'duration' => $this->faker->numberBetween(6, 24) . ' meses', // Duración del contrato
            'description' => $this->faker->text(250),
            'mode' => $this->faker->randomElement(['Presencial', 'Remoto']),
            'start_date' => $this->faker->date('Y-m-d', 'now'), // Fecha de inicio
            'finish_date' => $this->faker->date('Y-m-d', $this->faker->dateTimeBetween('6 months', '2 years')->format('Y-m-d')), // Fecha de finalización
            'cost' => $this->faker->randomFloat(2, 500, 5000), // Salario mensual
            'image' => '/img/employees/' . $this->faker->unique()->word() . '.png' // Ruta de imagen única
        ];
    }
}
