<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::all();
        return response()->json($vehiculos, 200);
    }

    public function store(Request $request)
    {
        $vehiculo = Vehiculo::create($request->all());
        return response()->json($vehiculo, 201);
    }

    public function show(string $id)
    {
        $vehiculo = Vehiculo::find($id);
        
        if ($vehiculo) {
            return response()->json($vehiculo, 200);
        }
        
        return response()->json(['message' => 'Vehiculo no encontrado'], 404);
    }

    public function update(Request $request, string $id)
    {
        $vehiculo = Vehiculo::find($id);
        
        if ($vehiculo) {
            $vehiculo->update($request->all());
            return response()->json($vehiculo, 200);
        }
        
        return response()->json(['message' => 'Vehiculo no encontrado'], 404);
    }

    public function destroy(string $id)
    {
        $vehiculo = Vehiculo::find($id);
        
        if ($vehiculo) {
            $vehiculo->delete();
            return response()->json(['message' => 'Vehiculo eliminado'], 200);
        }
        
        return response()->json(['message' => 'Vehiculo no encontrado'], 404);
    }
}