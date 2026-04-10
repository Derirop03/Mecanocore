<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Vehiculo;
use App\Models\Reparacion;
use App\Models\Lavado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FacturaController extends Controller
{
    public function index()
    {
        $vehiculosPendientes = Vehiculo::whereHas('reparaciones', function($q) {
            $q->where('estado', 'Entregado')->where('facturado', false);
        })->orWhereHas('lavados', function($q) {
            $q->where('estado', 'Entregado')->where('facturado', false);
        })->with([
            'reparaciones' => function($q) {
                $q->where('estado', 'Entregado')->where('facturado', false);
            },
            'lavados' => function($q) {
                $q->where('estado', 'Entregado')->where('facturado', false);
            }
        ])->get();

        $serviciosAgrupados = $vehiculosPendientes->map(function($vehiculo) {
            $conceptos = [];
            $totalSugerido = 0;

            foreach($vehiculo->reparaciones as $rep) {
                $conceptos[] = 'Taller: ' . $rep->descripcion_falla;
                $totalSugerido += $rep->precio;
            }

            foreach($vehiculo->lavados as $lav) {
                $conceptos[] = 'Lavadero: ' . $lav->tipo_servicio;
                $totalSugerido += $lav->precio;
            }

            return (object) [
                'vehiculo_id' => $vehiculo->id,
                'placa' => $vehiculo->placa,
                'descripcion' => implode(' + ', $conceptos),
                'precio_sugerido' => $totalSugerido
            ];
        });

        $facturas = Factura::with('vehiculo')->orderBy('created_at', 'desc')->get();

        return view('facturacion', compact('facturas', 'serviciosAgrupados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'concepto' => 'required',
            'total' => 'required|numeric',
        ]);

        $vehiculo_id = $request->vehiculo_id;

        Reparacion::where('vehiculo_id', $vehiculo_id)
            ->where('estado', 'Entregado')
            ->where('facturado', false)
            ->update(['facturado' => true]);

        Lavado::where('vehiculo_id', $vehiculo_id)
            ->where('estado', 'Entregado')
            ->where('facturado', false)
            ->update(['facturado' => true]);

        Factura::create([
            'vehiculo_id' => $vehiculo_id,
            'concepto' => $request->concepto,
            'total' => $request->total,
            'estado' => 'Pendiente'
        ]);

        return redirect('/facturacion');
    }

    public function actualizarEstado(Request $request, $id)
    {
        $factura = Factura::find($id);
        
        if ($factura) {
            $factura->estado = $request->estado;
            $factura->save();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function destroy($id)
    {
        Factura::destroy($id);
        return redirect('/facturacion');
    }
    public function generarPdf($id)
    {
       
        $factura = \App\Models\Factura::findOrFail($id);
        
        $pdf = Pdf::loadView('ticket', compact('factura'));
        
        return $pdf->stream('factura_'.$factura->id.'.pdf'); 
    }
}