@extends('layouts.app')

@section('titulo', 'Vehículos')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_vehiculos.css') }}">
    <style>
        .timeline-container { margin-top: 25px; padding-top: 20px; border-top: 2px solid #EEEEEE; }
        .timeline-container h3 { font-size: 16px; color: #2C3E50; margin-bottom: 20px; }
        .timeline-list { position: relative; padding-left: 30px; }
        .timeline-list::before { content: ''; position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background-color: #EEEEEE; }
        .timeline-item { position: relative; margin-bottom: 20px; }
        .timeline-icon { position: absolute; left: -31px; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 12px; background-color: white; border: 2px solid #EEEEEE; z-index: 1; }
        .timeline-icon.tipo-taller { color: #f39c12; border-color: #f39c12; }
        .timeline-icon.tipo-lavadero { color: #3498db; border-color: #3498db; }
        .timeline-content { background-color: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #EEEEEE; }
        .timeline-date { display: block; font-size: 12px; color: #7f8c8d; margin-bottom: 5px; font-weight: 600; }
        .timeline-title { margin: 0 0 5px 0; font-size: 14px; color: #212121; }
        .timeline-desc { margin: 0 0 10px 0; font-size: 13px; color: #34495e; line-height: 1.5; }
        .timeline-user { font-size: 11px; color: #7f8c8d; font-weight: 500; display: flex; align-items: center; gap: 5px; }
    </style>
@endsection

@section('contenido')
    <header class="topbar">
        <div class="titulo-seccion">
            <h1>Gestión de Vehículos</h1>
            <p>Administra el inventario de autos en el taller</p>
        </div>
        <div class="acciones-topbar">
            <button class="btn-nuevo" id="btn-abrir-modal-nuevo">
                <i class="fa-solid fa-plus"></i> Nuevo Vehículo
            </button>
        </div>
    </header>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p style="margin: 0 0 10px 0; font-weight: bold;"><i class="fa-solid fa-triangle-exclamation"></i> Revisa los siguientes errores:</p>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="contenedor-tabla">
        <table class="tabla-vehiculos">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Vehículo</th>
                    <th>Año</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehiculos as $vehiculo)
                <tr>
                    <td><span class="placa-badge">{{ $vehiculo->placa }}</span></td>
                    <td>
                        <div class="info-vehiculo">
                            <span class="marca">{{ $vehiculo->marca }}</span>
                            <span class="modelo">{{ $vehiculo->modelo }}</span>
                        </div>
                    </td>
                    <td>{{ $vehiculo->anio }}</td>
                    <td>{{ $vehiculo->cliente }}</td>
                    <td><span class="estado-badge estado-{{ strtolower(str_replace([' ', 'ó'], ['-', 'o'], $vehiculo->estado)) }}">{{ $vehiculo->estado }}</span></td>
                    <td>
                        <div class="acciones-tabla">
                            <button class="btn-icon view btn-abrir-ver" data-vehiculo="{{ json_encode($vehiculo) }}"><i class="fa-solid fa-eye"></i></button>
                            <button class="btn-icon edit btn-abrir-editar" data-vehiculo="{{ json_encode($vehiculo) }}"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('/vehiculos/'.$vehiculo->id) }}" method="POST" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal-overlay" id="modal-nuevo-vehiculo">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Registrar Nuevo Vehículo</h2>
                <button class="btn-cerrar-modal cerrar-modal-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ url('/vehiculos') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grupo">
                        <label>Placa</label>
                        <input type="text" name="placa" placeholder="Ej: ABC-123" required>
                    </div>
                    <div class="form-row">
                        <div class="form-grupo">
                            <label>Marca</label>
                            <input type="text" name="marca" placeholder="Ej: Toyota" required>
                        </div>
                        <div class="form-grupo">
                            <label>Modelo</label>
                            <input type="text" name="modelo" placeholder="Ej: Corolla" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-grupo">
                            <label>Año</label>
                            <input type="number" name="anio" placeholder="Ej: 2021" required>
                        </div>
                        <div class="form-grupo">
                            <label>Cliente / Propietario</label>
                            <input type="text" name="cliente" placeholder="Nombre completo" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar cerrar-modal-btn">Cancelar</button>
                    <button type="submit" class="btn-guardar">Guardar Vehículo</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modal-editar-vehiculo">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Vehículo</h2>
                <button class="btn-cerrar-modal cerrar-modal-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="form-editar" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-grupo">
                            <label>Placa</label>
                            <input type="text" name="placa" id="edit-placa" required>
                        </div>
                        <div class="form-grupo">
                            <label>Estado Actual</label>
                            <select name="estado" id="edit-estado" required>
                                <option value="Registrado">Registrado</option>
                                <option value="En Diagnóstico">En Diagnóstico</option>
                                <option value="En Reparación">En Reparación</option>
                                <option value="Listo">Listo</option>
                                <option value="Entregado">Entregado</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-grupo">
                            <label>Marca</label>
                            <input type="text" name="marca" id="edit-marca" required>
                        </div>
                        <div class="form-grupo">
                            <label>Modelo</label>
                            <input type="text" name="modelo" id="edit-modelo" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-grupo">
                            <label>Año</label>
                            <input type="number" name="anio" id="edit-anio" required>
                        </div>
                        <div class="form-grupo">
                            <label>Cliente / Propietario</label>
                            <input type="text" name="cliente" id="edit-cliente" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar cerrar-modal-btn">Cancelar</button>
                    <button type="submit" class="btn-guardar">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modal-ver-vehiculo">
        <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
            <div class="modal-header">
                <h2>Hoja de Vida del Vehículo</h2>
                <button class="btn-cerrar-modal cerrar-modal-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="detalles-grid">
                    <div class="detalle-item">
                        <span class="detalle-label">Placa</span>
                        <span class="detalle-valor placa-badge" id="view-placa"></span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-label">Estado</span>
                        <span class="detalle-valor" id="view-estado"></span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-label">Marca y Modelo</span>
                        <span class="detalle-valor" id="view-vehiculo"></span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-label">Año</span>
                        <span class="detalle-valor" id="view-anio"></span>
                    </div>
                    <div class="detalle-item">
                        <span class="detalle-label">Cliente</span>
                        <span class="detalle-valor" id="view-cliente"></span>
                    </div>
                </div>

                <div class="timeline-container">
                    <h3><i class="fa-solid fa-clock-rotate-left"></i> Historial de Servicios</h3>
                    <div class="timeline-list" id="view-timeline">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.cerrar-modal-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelectorAll('.modal-overlay').forEach(modal => modal.classList.remove('activo'));
        });
    });

    document.getElementById('btn-abrir-modal-nuevo').addEventListener('click', () => {
        document.getElementById('modal-nuevo-vehiculo').classList.add('activo');
    });

    document.querySelectorAll('.btn-abrir-editar').forEach(btn => {
        btn.addEventListener('click', function() {
            const vehiculo = JSON.parse(this.getAttribute('data-vehiculo'));
            document.getElementById('form-editar').action = `/vehiculos/${vehiculo.id}`;
            document.getElementById('edit-placa').value = vehiculo.placa;
            document.getElementById('edit-marca').value = vehiculo.marca;
            document.getElementById('edit-modelo').value = vehiculo.modelo;
            document.getElementById('edit-anio').value = vehiculo.anio;
            document.getElementById('edit-cliente').value = vehiculo.cliente;
            document.getElementById('edit-estado').value = vehiculo.estado;
            document.getElementById('modal-editar-vehiculo').classList.add('activo');
        });
    });

    document.querySelectorAll('.btn-abrir-ver').forEach(btn => {
        btn.addEventListener('click', function() {
            const vehiculo = JSON.parse(this.getAttribute('data-vehiculo'));
            
            document.getElementById('view-placa').textContent = vehiculo.placa;
            document.getElementById('view-vehiculo').textContent = `${vehiculo.marca} ${vehiculo.modelo}`;
            document.getElementById('view-anio').textContent = vehiculo.anio;
            document.getElementById('view-cliente').textContent = vehiculo.cliente;
            document.getElementById('view-estado').textContent = vehiculo.estado;

            let historial = [];
            
            if(vehiculo.reparaciones) {
                vehiculo.reparaciones.forEach(r => {
                    historial.push({
                        tipo: 'Taller Mecánico',
                        descripcion: r.descripcion_falla,
                        responsable: r.mecanico_asignado,
                        fecha: new Date(r.updated_at),
                        icono: 'fa-screwdriver-wrench',
                        clase: 'tipo-taller'
                    });
                });
            }
            
            if(vehiculo.lavados) {
                vehiculo.lavados.forEach(l => {
                    historial.push({
                        tipo: 'Lavadero',
                        descripcion: l.tipo_servicio,
                        responsable: l.operario,
                        fecha: new Date(l.updated_at),
                        icono: 'fa-droplet',
                        clase: 'tipo-lavadero'
                    });
                });
            }

            historial.sort((a, b) => b.fecha - a.fecha);

            const timelineContainer = document.getElementById('view-timeline');
            timelineContainer.innerHTML = '';

            if(historial.length === 0) {
                timelineContainer.innerHTML = '<p style="color:#7f8c8d; font-size:13px;">No hay servicios previos registrados para este vehículo.</p>';
            } else {
                historial.forEach(item => {
                    const fechaStr = item.fecha.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                    const horaStr = item.fecha.toLocaleTimeString('es-ES', { hour: '2-digit', minute:'2-digit' });
                    
                    timelineContainer.innerHTML += `
                        <div class="timeline-item">
                            <div class="timeline-icon ${item.clase}">
                                <i class="fa-solid ${item.icono}"></i>
                            </div>
                            <div class="timeline-content">
                                <span class="timeline-date">${fechaStr} - ${horaStr}</span>
                                <h4 class="timeline-title">${item.tipo}</h4>
                                <p class="timeline-desc">${item.descripcion}</p>
                                <span class="timeline-user"><i class="fa-solid fa-user"></i> ${item.responsable}</span>
                            </div>
                        </div>
                    `;
                });
            }

            document.getElementById('modal-ver-vehiculo').classList.add('activo');
        });
    });

    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            if(!confirm('¿Estás seguro de eliminar este vehículo del sistema? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection