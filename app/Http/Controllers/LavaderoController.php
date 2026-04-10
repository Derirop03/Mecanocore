<?php

namespace App\Http\Controllers;

use App\Models\Lavado;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class LavaderoController extends Controller
{
    public function index()
    {
        $lavados = Lavado::with('vehiculo')->where('estado', '!=', 'Entregado')->get();
        $vehiculos = Vehiculo::all();
        return view('lavadero', compact('lavados', 'vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'tipo_servicio' => 'required',
            'precio' => 'required|numeric'
        ]);

        Lavado::create([
            'vehiculo_id' => $request->vehiculo_id,
            'tipo_servicio' => $request->tipo_servicio,
            'operario' => $request->operario ?? 'Sin asignar',
            'estado' => 'Espera',
            'precio' => $request->precio
        ]);

        $vehiculo = Vehiculo::find($request->vehiculo_id);
        if ($vehiculo) {
            $vehiculo->estado = 'En Lavadero';
            $vehiculo->save();
        }

        return redirect('/lavadero');
    }

    public function actualizarEstado(Request $request, $id)
    {
        $lavado = Lavado::find($id);
        
        if ($lavado) {
            $lavado->estado = $request->estado;
            $lavado->save();

            $vehiculo = $lavado->vehiculo;
            if ($vehiculo) {
                $vehiculo->estado = $request->estado;
                $vehiculo->save();
            }

            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }
}