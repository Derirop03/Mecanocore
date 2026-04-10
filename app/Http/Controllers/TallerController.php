<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function index()
    {
        $reparaciones = Reparacion::with('vehiculo')->get();
        $vehiculos = Vehiculo::all();
        return view('taller', compact('reparaciones', 'vehiculos'));
    }

    public function store(Request $request)
    {
        // 1. Recibimos los arreglos del formulario
        $descripciones = $request->input('descripciones');
        $precios = $request->input('precios');
        
        // 2. Construimos un texto unificado para guardar en la BD
        $textoFallaDetallado = "";
        
        for ($i = 0; $i < count($descripciones); $i++) {
            $servicio = $descripciones[$i];
            $precioFormat = number_format($precios[$i], 0, ',', '.');
            
            $textoFallaDetallado .= "- " . $servicio . " ($ " . $precioFormat . ")\n";
        }

        
        \App\Models\Reparacion::create([
            'vehiculo_id' => $request->vehiculo_id,
            'mecanico_asignado' => $request->mecanico_asignado,
            'descripcion_falla' => $textoFallaDetallado, 
            'precio' => $request->precio, 
            'estado' => 'En Proceso' 
        ]);

        return redirect('/taller')->with('success', 'Servicios registrados y sumados correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mecanico_asignado' => 'required',
            'descripcion_falla' => 'required',
            'precio' => 'required|numeric',
        ]);

        $reparacion = Reparacion::findOrFail($id);
        $reparacion->update([
            'mecanico_asignado' => $request->mecanico_asignado,
            'descripcion_falla' => $request->descripcion_falla,
            'precio' => $request->precio
        ]);

        return redirect('/taller');
    }

    public function actualizarEstado(Request $request, $id)
    {
        $reparacion = Reparacion::find($id);
        
        if ($reparacion) {
            $reparacion->estado = $request->estado;
            $reparacion->save();

            $vehiculo = $reparacion->vehiculo;
            if ($vehiculo) {
                $vehiculo->estado = $request->estado;
                $vehiculo->save();
            }

            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function destroy($id)
    {
        $reparacion = Reparacion::findOrFail($id);
        $reparacion->delete();
        
        return redirect('/taller');
    }
}