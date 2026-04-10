@extends('layouts.app')

@section('titulo', 'Lavadero')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_taller.css') }}">
@endsection

@section('contenido')
    <header class="topbar">
        <div class="titulo-seccion">
            <h1>Lavadero</h1>
            <p>Gestión rápida de servicios de limpieza</p>
        </div>
        <div class="acciones-topbar">
            <button class="btn-nuevo" id="btn-abrir-modal">
                <i class="fa-solid fa-plus"></i> Registrar Ingreso
            </button>
        </div>
    </header>

    <div class="lavadero-grid">
        @foreach($lavados as $lavado)
            @php
                $claseEstado = 'estado-espera';
                $iconoTiempo = 'fa-regular fa-clock';
                $textoTiempo = 'En espera';
                
                if($lavado->estado == 'En Proceso') {
                    $claseEstado = 'estado-proceso';
                    $iconoTiempo = 'fa-solid fa-spinner fa-spin';
                    $textoTiempo = 'Lavando';
                } elseif($lavado->estado == 'Entregado') {
                    $claseEstado = 'estado-finalizado';
                    $iconoTiempo = 'fa-solid fa-check-circle';
                    $textoTiempo = 'Listo para entrega';
                }
            @endphp

            <div class="lavado-card {{ $claseEstado }}">
                <div class="card-header">
                    <span class="placa-badge">{{ $lavado->vehiculo->placa }}</span>
                    <span class="tiempo-ingreso"><i class="{{ $iconoTiempo }}"></i> {{ $textoTiempo }}</span>
                </div>
                <div class="card-body">
                    <h4 class="vehiculo-info">{{ $lavado->vehiculo->marca }} {{ $lavado->vehiculo->modelo }}</h4>
                    <p class="tipo-servicio">{{ $lavado->tipo_servicio }}</p>
                    <p style="font-size: 13px; color: #2ecc71; font-weight: 600; margin-top: 5px;">$ {{ number_format($lavado->precio, 0, ',', '.') }}</p>
                </div>
                <div class="card-footer">
                    <span class="operario"><i class="fa-solid fa-user"></i> {{ $lavado->operario }}</span>
                    
                    @if($lavado->estado == 'Espera')
                        <button class="btn-accion iniciar btn-cambiar-estado" data-id="{{ $lavado->id }}" data-estado="En Proceso">Iniciar</button>
                    @elseif($lavado->estado == 'En Proceso')
                        <button class="btn-accion terminar btn-cambiar-estado" data-id="{{ $lavado->id }}" data-estado="Entregado">Entregar</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal-overlay" id="modal-nuevo-lavado">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Registrar Ingreso a Lavadero</h2>
                <button class="btn-cerrar-modal" id="btn-cerrar-modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ url('/lavadero') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grupo">
                        <label>Seleccionar Vehículo</label>
                        <select name="vehiculo_id" required>
                            <option value="" disabled selected>Elija un vehículo registrado...</option>
                            @foreach($vehiculos as $vehiculo)
                                <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-grupo" style="flex: 2;">
                            <label>Tipo de Servicio</label>
                            <select name="tipo_servicio" id="select_servicio" required>
                                <option value="" disabled selected data-precio="">Elija el servicio...</option>
                                <option value="Lavado Sencillo" data-precio="25000">Lavado Sencillo</option>
                                <option value="Sencillo + Chasis" data-precio="40000">Sencillo + Chasis</option>
                                <option value="Lavado General + Polichado" data-precio="80000">Lavado General + Polichado</option>
                                <option value="Limpieza de Tapicería" data-precio="120000">Limpieza de Tapicería</option>
                            </select>
                        </div>
                        <div class="form-grupo" style="flex: 1;">
                            <label>Precio ($)</label>
                            <input type="number" name="precio" id="precio_estimado" required>
                        </div>
                    </div>
                    <div class="form-grupo">
                        <label>Operario Asignado (Opcional)</label>
                        <input type="text" name="operario" placeholder="Nombre del operario">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar" id="btn-cancelar-modal">Cancelar</button>
                    <button type="submit" class="btn-guardar">Registrar Ingreso</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('modal-nuevo-lavado');
    const btnAbrir = document.getElementById('btn-abrir-modal');
    const btnCerrar = document.getElementById('btn-cerrar-modal');
    const btnCancelar = document.getElementById('btn-cancelar-modal');

    btnAbrir.addEventListener('click', () => { modal.classList.add('activo'); });
    btnCerrar.addEventListener('click', () => { modal.classList.remove('activo'); });
    btnCancelar.addEventListener('click', () => { modal.classList.remove('activo'); });
    window.addEventListener('click', (e) => { if (e.target === modal) modal.classList.remove('activo'); });

    document.getElementById('select_servicio').addEventListener('change', function() {
        const precio = this.options[this.selectedIndex].getAttribute('data-precio');
        document.getElementById('precio_estimado').value = precio;
    });

    document.querySelectorAll('.btn-cambiar-estado').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nuevoEstado = this.getAttribute('data-estado');

            if (nuevoEstado === 'Entregado') {
                if (!confirm('¿Marcar como entregado? Esto actualizará el vehículo y lo pasará al historial.')) return;
            }

            fetch(`/lavadero/${id}/estado`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ estado: nuevoEstado })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.location.reload(); 
                }
            });
        });
    });
</script>
@endsection