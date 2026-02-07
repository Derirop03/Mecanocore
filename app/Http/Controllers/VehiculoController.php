<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehiculo; // Importante: Conectar con el Modelo

class VehiculoController extends Controller
{
    // 1. Mostrar el formulario
    public function create()
    {
        return view('vehiculos.ingreso');
    }

    // 2. Guardar los datos del formulario
    public function store(Request $request)
    {
        // Validar que no envíen campos vacíos
        $request->validate([
            'placa' => 'required',
            'marca' => 'required',
            'descripcion_falla' => 'required',
        ]);

        // Guardar en Base de Datos
        Vehiculo::create($request->all());

        // Regresar con mensaje de éxito
        return back()->with('success', '¡Vehículo registrado correctamente!');
    }
}
