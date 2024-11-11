<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Restaurante;  // Asegúrate de tener el modelo Restaurante
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener todos los empleados desde la base de datos
        $empleados = Empleado::all();
        
        // Obtener todos los restaurantes desde la base de datos
        $restaurantes = Restaurante::all();

        // Total de restaurantes
        $totalRestaurantes = $restaurantes->count();

        // Pasar los datos a la vista de Inertia
        return Inertia::render('Dashboard', [
            'empleados' => $empleados,
            'totalRestaurantes' => $totalRestaurantes,
            'restaurantes' => $restaurantes,
        ]);
    }
}
