@extends('layouts.app')

@section('titulo', 'Dashboard - Resumen')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_sistema.css') }}">
@endsection

@section('contenido')
    <header class="topbar">
        <div class="saludo">
            <h1>Hola, {{ Auth::user()->name }}</h1>
            <p>Aquí tienes el resumen de tu taller hoy.</p>
        </div>
        <div class="perfil-usuario">
            <div class="notificacion-icon">
                <i class="fa-solid fa-bell"></i>
                <div class="punto-rojo"></div>
            </div>
            <div class="avatar">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=0D7377&color=fff" alt="Avatar">
            </div>
        </div>
    </header>

    <div class="dashboard-grid">
        <div class="card-modulo">
            <div class="card-icon"><i class="fa-solid fa-car"></i></div>
            <div class="card-info">
                <h3>Control de Vehículos</h3>
                <p>Registrar ingresos y salidas</p>
            </div>
            <a href="{{ url('/vehiculos') }}" class="card-link"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
        <div class="card-modulo">
            <div class="card-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            <div class="card-info">
                <h3>Facturación</h3>
                <p>Generar cobros y presupuestos</p>
            </div>
            <a href="{{ url('/facturacion') }}" class="card-link"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
        <div class="card-modulo">
            <div class="card-icon"><i class="fa-solid fa-droplet"></i></div>
            <div class="card-info">
                <h3>Servicio de Lavado</h3>
                <p>Estado de limpieza y detallado</p>
            </div>
            <a href="{{ url('/lavadero') }}" class="card-link"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
        <div class="card-modulo">
            <div class="card-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
            <div class="card-info">
                <h3>Taller Mecánico</h3>
                <p>Gestión de reparaciones</p>
            </div>
            <a href="{{ url('/taller') }}" class="card-link"><i class="fa-solid fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="seccion-stats">
        <div class="stat-box">
            <h4>Vehículos en Taller</h4>
            <span class="numero">{{ $vehiculosTaller }}</span>
            <div class="barra-progreso">
                <div class="progreso" style="width: 45%;"></div>
            </div>
        </div>
        
        <div class="stat-box">
            <h4>Lavados Pendientes</h4>
            <span class="numero">{{ $lavadosPendientes }}</span>
            <div class="barra-progreso">
                <div class="progreso" style="width: 25%;"></div>
            </div>
        </div>
        
        <div class="stat-box">
            <h4>Ingresos del Día</h4>
            <span class="numero">{{ $ingresosHoyStr }}</span>
            <div class="barra-progreso">
                <div class="progreso" style="width: 80%;"></div>
            </div>
        </div>
    </div>
@endsection