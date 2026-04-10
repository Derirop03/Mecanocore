@extends('layouts.app')

@section('titulo', 'Historial')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_historial.css') }}">
    <style>
        .tipo-taller { background-color: rgba(243, 156, 18, 0.1); color: #f39c12; }
        .tipo-lavadero { background-color: rgba(52, 152, 219, 0.1); color: #3498db; }
    </style>
@endsection

@section('contenido')
    <header class="topbar">
        <div class="titulo-seccion">
            <h1>Historial de Servicios</h1>
            <p>Consulta el registro global de vehículos entregados</p>
        </div>
        
        <div class="acciones-topbar">
            <form action="{{ url('/historial') }}" method="GET" class="form-busqueda">
                <input type="text" name="buscar" placeholder="Buscar por placa..." value="{{ request('buscar') }}">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </div>
    </header>

    <div class="contenedor-tabla">
        <table class="tabla-historial">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Placa</th>
                    <th>Vehículo</th>
                    <th>Área / Servicio</th>
                    <th>Detalle del Trabajo</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historial as $registro)
                <tr>
                    <td>
                        <div class="fecha-box">
                            <span class="fecha">{{ $registro->fecha->format('d/m/Y') }}</span>
                            <span class="hora">{{ $registro->fecha->format('H:i') }}</span>
                        </div>
                    </td>
                    <td><span class="placa-badge">{{ $registro->vehiculo->placa }}</span></td>
                    <td>
                        <div class="info-vehiculo">
                            <span class="marca">{{ $registro->vehiculo->marca }}</span>
                            <span class="modelo">{{ $registro->vehiculo->modelo }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="estado-badge {{ $registro->tipo == 'Taller' ? 'tipo-taller' : 'tipo-lavadero' }}">
                            <i class="fa-solid {{ $registro->tipo == 'Taller' ? 'fa-screwdriver-wrench' : 'fa-droplet' }}"></i> {{ $registro->tipo }}
                        </span>
                    </td>
                    <td class="col-falla">{{ $registro->descripcion }}</td>
                    <td><span class="mecanico-badge"><i class="fa-solid fa-user"></i> {{ $registro->responsable }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No se encontraron vehículos entregados en el historial.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection