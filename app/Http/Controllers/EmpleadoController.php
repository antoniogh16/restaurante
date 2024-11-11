<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmpleadoController extends Controller
{
    /**
     * Muestra una lista de empleados.
     */
    public function index()
    {
        $empleados = Empleado::all();
        return Inertia::render('Empleados/Index', [
            'empleados' => $empleados
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo empleado.
     */
    public function create()
    {
        return Inertia::render('Empleados/Create');
    }

    /**
     * Almacena un nuevo empleado en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'description' => 'required|string|max:250',
            'mode' => 'required|string|max:50',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'cost' => 'required|numeric',
            'image' => 'required|string|max:100',
        ]);

        $empleado = Empleado::create($validated);

        // Responder con el empleado creado y un mensaje de éxito
        return response()->json([
            'message' => 'Empleado creado exitosamente.',
            'empleado' => $empleado
        ], 201);
    }

    /**
     * Muestra los detalles de un empleado específico.
     */
    public function show(Empleado $empleado)
    {
        return Inertia::render('Empleados/Show', [
            'empleado' => $empleado
        ]);
    }

    /**
     * Muestra el formulario para editar un empleado específico.
     */
    public function edit(Empleado $empleado)
    {
        return Inertia::render('Empleados/Edit', [
            'empleado' => $empleado
        ]);
    }

    /**
     * Actualiza un empleado específico en la base de datos.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
            'description' => 'required|string|max:250',
            'mode' => 'required|string|max:50',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'cost' => 'required|numeric',
            'image' => 'required|string|max:100',
        ]);

        $empleado->update($validated);

        // Responder con el empleado actualizado y un mensaje de éxito
        return response()->json([
            'message' => 'Empleado actualizado exitosamente.',
            'empleado' => $empleado
        ]);
    }

    /**
     * Elimina un empleado específico de la base de datos.
     */
    public function destroy(Empleado $empleado)
    {
        $empleado->delete();

        // Responder con un mensaje de éxito
        return response()->json([
            'message' => 'Empleado eliminado exitosamente.'
        ]);
    }
}
