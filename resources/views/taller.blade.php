@extends('layouts.app')

@section('titulo', 'Taller Mecánico')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_taller.css') }}">
@endsection

@section('contenido')
    <header class="topbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="titulo-seccion">
            <h1 style="margin: 0;">Taller Mecánico</h1>
            <p style="margin: 5px 0 0 0; color: #666;">Tablero de control de reparaciones activas</p>
        </div>
        <div class="acciones-topbar">
            <button class="btn-nuevo" id="btn-nuevo-ingreso" style="background-color: #0D7377; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-family: 'Poppins', sans-serif; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-plus"></i> Nuevo Ingreso
            </button>
        </div>
    </header>

    <div class="kanban-board">
        <div class="kanban-column" data-estado="En Diagnóstico">
            <div class="column-header diagnostico">
                <h3>En Diagnóstico</h3>
                <span class="contador">{{ $reparaciones->where('estado', 'En Diagnóstico')->count() }}</span>
            </div>
            <div class="column-body">
                @foreach($reparaciones->where('estado', 'En Diagnóstico') as $rep)
                <div class="kanban-card" draggable="true" data-id="{{ $rep->id }}">
                    <div class="card-top" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="placa">{{ $rep->vehiculo->placa }}</span>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-icon btn-abrir-editar" data-reparacion="{{ json_encode($rep) }}" style="background: none; border: none; color: #3498db; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('/taller/'.$rep->id) }}" method="POST" class="form-eliminar-orden" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar-card" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <h4>{{ $rep->vehiculo->marca }} {{ $rep->vehiculo->modelo }}</h4>
                    <p class="falla">{{ $rep->descripcion_falla }}</p>
                    <p style="font-size: 13px; color: #2ecc71; font-weight: 600; margin-top: 5px;">$ {{ number_format($rep->precio, 0, ',', '.') }}</p>
                    <div class="card-bottom">
                        <span class="mecanico"><i class="fa-solid fa-user-gear"></i> {{ $rep->mecanico_asignado }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="kanban-column" data-estado="En Reparación">
            <div class="column-header reparacion">
                <h3>En Reparación</h3>
                <span class="contador">{{ $reparaciones->where('estado', 'En Reparación')->count() }}</span>
            </div>
            <div class="column-body">
                @foreach($reparaciones->where('estado', 'En Reparación') as $rep)
                <div class="kanban-card" draggable="true" data-id="{{ $rep->id }}">
                    <div class="card-top" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="placa">{{ $rep->vehiculo->placa }}</span>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-icon btn-abrir-editar" data-reparacion="{{ json_encode($rep) }}" style="background: none; border: none; color: #3498db; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('/taller/'.$rep->id) }}" method="POST" class="form-eliminar-orden" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar-card" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <h4>{{ $rep->vehiculo->marca }} {{ $rep->vehiculo->modelo }}</h4>
                    <p class="falla">{{ $rep->descripcion_falla }}</p>
                    <p style="font-size: 13px; color: #2ecc71; font-weight: 600; margin-top: 5px;">$ {{ number_format($rep->precio, 0, ',', '.') }}</p>
                    <div class="card-bottom">
                        <span class="mecanico"><i class="fa-solid fa-user-gear"></i> {{ $rep->mecanico_asignado }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="kanban-column" data-estado="Listo">
            <div class="column-header listo">
                <h3>Listo</h3>
                <span class="contador">{{ $reparaciones->where('estado', 'Listo')->count() }}</span>
            </div>
            <div class="column-body">
                @foreach($reparaciones->where('estado', 'Listo') as $rep)
                <div class="kanban-card" draggable="true" data-id="{{ $rep->id }}">
                    <div class="card-top" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="placa">{{ $rep->vehiculo->placa }}</span>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-icon btn-abrir-editar" data-reparacion="{{ json_encode($rep) }}" style="background: none; border: none; color: #3498db; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('/taller/'.$rep->id) }}" method="POST" class="form-eliminar-orden" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar-card" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <h4>{{ $rep->vehiculo->marca }} {{ $rep->vehiculo->modelo }}</h4>
                    <p class="falla">{{ $rep->descripcion_falla }}</p>
                    <p style="font-size: 13px; color: #2ecc71; font-weight: 600; margin-top: 5px;">$ {{ number_format($rep->precio, 0, ',', '.') }}</p>
                    <div class="card-bottom">
                        <span class="mecanico"><i class="fa-solid fa-user-gear"></i> {{ $rep->mecanico_asignado }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="kanban-column" data-estado="Entregado">
            <div class="column-header entregado">
                <h3>Entregado</h3>
                <span class="contador">{{ $reparaciones->where('estado', 'Entregado')->count() }}</span>
            </div>
            <div class="column-body">
                @foreach($reparaciones->where('estado', 'Entregado') as $rep)
                <div class="kanban-card" draggable="true" data-id="{{ $rep->id }}">
                    <div class="card-top" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="placa">{{ $rep->vehiculo->placa }}</span>
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn-icon btn-abrir-editar" data-reparacion="{{ json_encode($rep) }}" style="background: none; border: none; color: #3498db; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-pen"></i></button>
                            <form action="{{ url('/taller/'.$rep->id) }}" method="POST" class="form-eliminar-orden" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar-card" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <h4>{{ $rep->vehiculo->marca }} {{ $rep->vehiculo->modelo }}</h4>
                    <p class="falla">{{ $rep->descripcion_falla }}</p>
                    <p style="font-size: 13px; color: #2ecc71; font-weight: 600; margin-top: 5px;">$ {{ number_format($rep->precio, 0, ',', '.') }}</p>
                    <div class="card-bottom">
                        <span class="mecanico"><i class="fa-solid fa-user-gear"></i> {{ $rep->mecanico_asignado }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="modal-nuevo-ingreso" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; opacity: 0; visibility: hidden; transition: 0.3s; z-index: 2000;">
        <div class="modal-content" style="background: white; padding: 30px; border-radius: 12px; width: 600px; max-width: 90%;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h2 style="margin: 0; color: #333;">Crear Orden de Trabajo</h2>
                <button type="button" class="btn-cerrar-ingreso" style="background: none; border: none; font-size: 20px; color: #999; cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <form action="{{ url('/taller') }}" method="POST">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Seleccionar Vehículo Registrado</label>
                    <select name="vehiculo_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        <option value="" disabled selected>Elija un vehículo...</option>
                        @foreach($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Mecánico Asignado</label>
                    <input type="text" name="mecanico_asignado" value="{{ Auth::user()->name }}" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Detalle de Servicios</label>
                    <div id="contenedor-servicios">
                        <div class="fila-servicio" style="display: flex; gap: 10px; margin-bottom: 10px;">
                            <input type="text" name="descripciones[]" placeholder="Ej: Cambio de aceite" required style="flex: 2; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
                            <input type="number" name="precios[]" placeholder="Valor ($)" class="precio-item" required style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
                            <button type="button" class="btn-eliminar-fila" style="padding: 10px; background-color: #e74c3c; color: white; border: none; border-radius: 6px; cursor: pointer; display: none;"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <button type="button" id="btn-agregar-servicio" style="background-color: #3498db; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 12px; margin-top: 5px;">
                        <i class="fa-solid fa-plus"></i> Agregar otro servicio
                    </button>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Costo Total del Arreglo ($)</label>
                    <input type="number" name="precio" id="precio_total" readonly style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #0D7377; background-color: #f4fdfd; font-weight: bold; color: #0D7377; box-sizing: border-box;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                    <button type="button" class="btn-cerrar-ingreso" style="padding: 10px 20px; border-radius: 6px; border: 1px solid #ddd; background: white; cursor: pointer; font-weight: 600;">Cancelar</button>
                    <button type="submit" style="padding: 10px 20px; border-radius: 6px; border: none; background: #0D7377; color: white; cursor: pointer; font-weight: 600;">Crear Orden</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modal-editar-orden">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Orden de Trabajo</h2>
                <button type="button" class="btn-cerrar-modal cerrar-modal-editar"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="form-editar-orden" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-grupo">
                        <label>Vehículo (Placa)</label>
                        <input type="text" id="edit-placa-display" readonly style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background-color: #f9f9f9; color: #777; font-weight: bold;">
                    </div>
                    <div class="form-row">
                        <div class="form-grupo" style="flex: 2;">
                            <label>Mecánico Asignado</label>
                            <input type="text" name="mecanico_asignado" id="edit-mecanico" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                        <div class="form-grupo" style="flex: 1;">
                            <label>Precio Actualizado ($)</label>
                            <input type="number" name="precio" id="edit-precio" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                    </div>
                    <div class="form-grupo">
                        <label>Descripción de la Falla / Trabajo a realizar</label>
                        <textarea name="descripcion_falla" id="edit-descripcion" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; resize: vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar cerrar-modal-editar" style="padding: 10px 20px; border-radius: 6px; border: 1px solid #ddd; background: white; cursor: pointer;">Cancelar</button>
                    <button type="submit" class="btn-guardar" style="padding: 10px 20px; border-radius: 6px; border: none; background: #0D7377; color: white; cursor: pointer;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const cards = document.querySelectorAll('.kanban-card');
    const columns = document.querySelectorAll('.kanban-column');

    cards.forEach(card => {
        card.addEventListener('dragstart', () => { card.classList.add('dragging'); });
        card.addEventListener('dragend', () => { card.classList.remove('dragging'); });
    });

    columns.forEach(column => {
        column.addEventListener('dragover', e => {
            e.preventDefault(); 
            column.classList.add('drag-over');
            const draggingCard = document.querySelector('.dragging');
            if(draggingCard) {
                column.querySelector('.column-body').appendChild(draggingCard);
            }
        });

        column.addEventListener('dragleave', () => { column.classList.remove('drag-over'); });

        column.addEventListener('drop', e => {
            e.preventDefault();
            column.classList.remove('drag-over');
            
            const draggingCard = document.querySelector('.dragging');
            if(draggingCard) {
                const cardId = draggingCard.getAttribute('data-id');
                const nuevoEstado = column.getAttribute('data-estado');

                fetch(`/taller/${cardId}/estado`, {
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
            }
        });
    });

    document.querySelectorAll('.form-eliminar-orden').forEach(form => {
        form.addEventListener('submit', function(e) {
            if(!confirm('¿Estás seguro de eliminar esta orden de trabajo? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });

    const modalEditar = document.getElementById('modal-editar-orden');
    
    document.querySelectorAll('.btn-abrir-editar').forEach(btn => {
        btn.addEventListener('click', function() {
            const data = JSON.parse(this.getAttribute('data-reparacion'));
            
            document.getElementById('form-editar-orden').action = `/taller/${data.id}`;
            document.getElementById('edit-placa-display').value = data.vehiculo ? data.vehiculo.placa : 'N/A';
            document.getElementById('edit-mecanico').value = data.mecanico_asignado;
            document.getElementById('edit-precio').value = data.precio;
            document.getElementById('edit-descripcion').value = data.descripcion_falla;
            
            modalEditar.classList.add('activo');
        });
    });

    document.querySelectorAll('.cerrar-modal-editar').forEach(btn => {
        btn.addEventListener('click', () => {
            modalEditar.classList.remove('activo');
        });
    });

    const modalIngreso = document.getElementById('modal-nuevo-ingreso');
    const btnNuevoIngreso = document.getElementById('btn-nuevo-ingreso');
    const btnsCerrarIngreso = document.querySelectorAll('.btn-cerrar-ingreso');

    if (btnNuevoIngreso) {
        btnNuevoIngreso.addEventListener('click', () => {
            modalIngreso.style.opacity = '1';
            modalIngreso.style.visibility = 'visible';
        });
    }

    btnsCerrarIngreso.forEach(btn => {
        btn.addEventListener('click', () => {
            modalIngreso.style.opacity = '0';
            modalIngreso.style.visibility = 'hidden';
        });
    });

    window.addEventListener('click', (e) => {
        if (e.target === modalEditar) modalEditar.classList.remove('activo');
        if (e.target === modalIngreso) {
            modalIngreso.style.opacity = '0';
            modalIngreso.style.visibility = 'hidden';
        }
    });

    const btnAgregar = document.getElementById('btn-agregar-servicio');
    const contenedorServicios = document.getElementById('contenedor-servicios');
    const inputTotal = document.getElementById('precio_total');

    function recalcularTotal() {
        let total = 0;
        document.querySelectorAll('.precio-item').forEach(input => {
            if (input.value) total += parseFloat(input.value);
        });
        inputTotal.value = total;
    }

    if (btnAgregar) {
        btnAgregar.addEventListener('click', () => {
            const nuevaFila = document.createElement('div');
            nuevaFila.className = 'fila-servicio';
            nuevaFila.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px;';
            nuevaFila.innerHTML = `
                <input type="text" name="descripciones[]" placeholder="Siguiente servicio..." required style="flex: 2; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
                <input type="number" name="precios[]" placeholder="Valor ($)" class="precio-item" required style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box;">
                <button type="button" class="btn-eliminar-fila" style="padding: 10px; background-color: #e74c3c; color: white; border: none; border-radius: 6px; cursor: pointer;"><i class="fa-solid fa-trash"></i></button>
            `;
            contenedorServicios.appendChild(nuevaFila);
            
            nuevaFila.querySelector('.precio-item').addEventListener('input', recalcularTotal);
            
            nuevaFila.querySelector('.btn-eliminar-fila').addEventListener('click', function() {
                nuevaFila.remove();
                recalcularTotal();
            });
        });
    }

    const primerPrecio = document.querySelector('.precio-item');
    if (primerPrecio) {
        primerPrecio.addEventListener('input', recalcularTotal);
    }
</script>
@endsection