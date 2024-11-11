<?php

namespace Database\Factories;

use App\Models\Restaurante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurante>
 */
class RestauranteFactory extends Factory
{
    protected $model = Restaurante::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(), // Nombre del restaurante
            'last_name' => $this->faker->lastName(), // Nombre del propietario o administrador
            'country_id' => $this->faker->numberBetween(1, 50), // ID de país entre 1 y 50
        ];
    }
}
