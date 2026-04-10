<?php

namespace App\Http\Controllers;

use App\Models\Reparacion;
use App\Models\Lavado;
use App\Models\Factura;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $vehiculosTaller = Reparacion::where('estado', '!=', 'Entregado')->count();

        $lavadosPendientes = Lavado::where('estado', '!=', 'Entregado')->count();

        $hoy = Carbon::today();
        $ingresosHoyRaw = Factura::where('estado', 'Pagada')
            ->whereDate('created_at', $hoy)
            ->sum('total');

        $ingresosHoyStr = '$' . number_format($ingresosHoyRaw, 0, ',', '.');

        return view('sistema', compact('vehiculosTaller', 'lavadosPendientes', 'ingresosHoyStr'));
    }
}