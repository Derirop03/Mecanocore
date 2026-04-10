<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        
        $vehiculos = Vehiculo::with([
            'reparaciones' => function($query) {
                $query->withTrashed()->where('estado', 'Entregado')->orderBy('updated_at', 'desc');
            }, 
            'lavados' => function($query) {
                $query->withTrashed()->where('estado', 'Entregado')->orderBy('updated_at', 'desc');
            }
        ])->get();

        
        return view('vehiculos', compact('vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required',
        ]);

        $query = \App\Models\Vehiculo::query();
       
        if (in_array(\Illuminate\Database\Eloquent\SoftDeletes::class, class_uses_recursive(\App\Models\Vehiculo::class))) {
            $query->withTrashed();
        }

        $vehiculo = $query->where('placa', $request->placa)->first();

        if ($vehiculo) {
            if (method_exists($vehiculo, 'restore')) {
                $vehiculo->restore(); 
            }
            $vehiculo->update($request->all()); 
            
            return redirect('/vehiculos')->with('success', 'El vehículo ya existía en el sistema y ha sido recuperado exitosamente.');
        }

        \App\Models\Vehiculo::create($request->all());
    
        return redirect('/vehiculos')->with('success', 'Vehículo nuevo registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo) {
            return redirect('/vehiculos')->with('error', 'Vehículo no encontrado');
        }

        $vehiculo->update($request->all());
        
        return redirect('/vehiculos')->with('success', 'Vehículo actualizado exitosamente');
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo) {
            return redirect('/vehiculos')->with('error', 'Vehículo no encontrado');
        }

        $vehiculo->delete(); 

        return redirect('/vehiculos')->with('success', 'Vehículo eliminado con éxito');
    }
}