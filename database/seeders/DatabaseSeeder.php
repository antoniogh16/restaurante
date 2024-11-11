<?php

namespace Database\Seeders;

use App\Models\Empleado;
use App\Models\Restaurante;
use App\Models\Country;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 50 países
        Country::factory(50)->create();
        
        // Crear 25 empleados
        Empleado::factory(25)->create();
        
        // Crear 15 restaurantes
        Restaurante::factory(15)->create();
        
        // Asignar empleados aleatorios a cada restaurante
        Restaurante::all()->each(function ($restaurante) {
            $restaurante->empleados()->attach(
                Empleado::inRandomOrder()->take(random_int(1, 5))->pluck('id') // Asignar entre 1 y 5 empleados aleatorios
            );
        });
    }
}
