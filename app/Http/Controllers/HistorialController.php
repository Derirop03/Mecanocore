<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\Lavado;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $reparacionesQuery = Reparacion::withTrashed()->with('vehiculo')->where('estado', 'Entregado');
        if ($buscar) {
            $reparacionesQuery->whereHas('vehiculo', function($q) use ($buscar) {
                $q->where('placa', 'like', '%' . strtoupper($buscar) . '%');
            });
        }
        $reparaciones = $reparacionesQuery->get()->map(function($item) {
            return (object) [
                'id_registro' => 'REP-' . $item->id,
                'tipo' => 'Taller',
                'fecha' => $item->updated_at,
                'vehiculo' => $item->vehiculo,
                'descripcion' => $item->descripcion_falla,
                'responsable' => $item->mecanico_asignado,
            ];
        });

        $lavadosQuery = Lavado::withTrashed()->with('vehiculo')->where('estado', 'Entregado');
        if ($buscar) {
            $lavadosQuery->whereHas('vehiculo', function($q) use ($buscar) {
                $q->where('placa', 'like', '%' . strtoupper($buscar) . '%');
            });
        }
        $lavados = $lavadosQuery->get()->map(function($item) {
            return (object) [
                'id_registro' => 'LAV-' . $item->id,
                'tipo' => 'Lavadero',
                'fecha' => $item->updated_at,
                'vehiculo' => $item->vehiculo,
                'descripcion' => $item->tipo_servicio,
                'responsable' => $item->operario,
            ];
        });

        // Ordenamos por fecha
        $historial = $reparaciones->concat($lavados)->sortByDesc('fecha');
        
        // ¡LA MAGIA OCURRE AQUÍ!
        // Si la petición viene de Postman (API), devolvemos JSON puro
        if ($request->wantsJson() || $request->is('api/*')) {
            // Usamos values()->all() para que el JSON quede como un arreglo limpio
            return response()->json($historial->values()->all(), 200);
        }

        // Si la petición viene del navegador (Sistema Web), devolvemos la vista HTML normal
        return view('historial', compact('historial'));
    }
}