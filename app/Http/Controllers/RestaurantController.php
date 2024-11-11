<?php
namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RestaurantController extends Controller
{
    /**
     * Muestra la lista de restaurantes.
     */
    public function index()
    {
        $countries = Country::all();
        $restaurantes = Restaurante::with('country:id,country')->get();

        return Inertia::render('Restaurantes/Index', [
            'restaurantes' => $restaurantes,
            'countries' => $countries,
        ]);
    }

    /**
     * Muestra el formulario para crear un nuevo restaurante.
     */
    public function create()
    {
        $countries = Country::all();
        return Inertia::render('Restaurantes/Create', [
            'countries' => $countries,
        ]);
    }

    /**
     * Almacena un nuevo restaurante en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'country_id' => 'required|exists:countries,id',
        ]);

        Restaurante::create($validated);

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante creado exitosamente.');
    }

    /**
     * Muestra un restaurante específico.
     */
    public function show(Restaurante $restaurante)
    {
        return Inertia::render('Restaurantes/Show', [
            'restaurante' => $restaurante->load('country', 'empleados'),
        ]);
    }

    /**
     * Muestra el formulario para editar un restaurante específico.
     */
    public function edit(Restaurante $restaurante)
    {
        $countries = Country::all();
        return Inertia::render('Restaurantes/Edit', [
            'restaurante' => $restaurante,
            'countries' => $countries,
        ]);
    }

    /**
     * Actualiza un restaurante específico en la base de datos.
     */
    public function update(Request $request, Restaurante $restaurante)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'last_name' => 'required|string|max:80',
            'country_id' => 'required|exists:countries,id',
        ]);

        $restaurante->update($validated);

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante actualizado exitosamente.');
    }

    /**
     * Elimina un restaurante específico de la base de datos.
     */
    public function destroy(Restaurante $restaurante)
    {
        $restaurante->delete();
        return redirect()->route('restaurantes.index')->with('success', 'Restaurante eliminado exitosamente.');
    }
}
