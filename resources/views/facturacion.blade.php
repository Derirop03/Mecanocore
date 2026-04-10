@extends('layouts.app')

@section('titulo', 'Facturación')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_vehiculos.css') }}">
    <style>
        .estado-pendiente { background-color: rgba(243, 156, 18, 0.1); color: #f39c12; border: 1px solid rgba(243, 156, 18, 0.2); }
        .estado-pagada { background-color: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.2); }
        .monto { font-weight: 700; color: #2C3E50; font-size: 15px; font-family: 'Courier New', Courier, monospace; }
        .btn-pagar { background-color: #2ecc71; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 5px; transition: 0.3s; }
        .btn-pagar:hover { background-color: #27ae60; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(46, 204, 113, 0.2); }
        .btn-pagar i { font-size: 14px; }
        .tabla-vehiculos td strong { color: #0D7377; font-weight: 600; }
        .modal-content select, .modal-content textarea { width: 100%; padding: 12px; border: 2px solid #EEEEEE; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; background-color: #f8f9fa; outline: none; transition: 0.3s; box-sizing: border-box; }
        .modal-content select:focus, .modal-content textarea:focus { border-color: #0D7377; background-color: white; }
        .contenedor-tabla { background-color: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    </style>
@endsection

@section('contenido')
    <header class="topbar">
        <div class="titulo-seccion">
            <h1>Facturación y Cobros</h1>
            <p>Gestiona los pagos agrupados por vehículo</p>
        </div>
        <div class="acciones-topbar">
            <button class="btn-nuevo" id="btn-abrir-modal-nuevo">
                <i class="fa-solid fa-file-invoice-dollar"></i> Nueva Factura
            </button>
        </div>
    </header>

    <div class="contenedor-tabla">
        <table class="tabla-vehiculos">
            <thead>
                <tr>
                    <th>N° Factura</th>
                    <th>Fecha</th>
                    <th>Placa</th>
                    <th>Concepto Agrupado</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($facturas as $factura)
                <tr>
                    <td><strong>#FAC-{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $factura->created_at->format('d/m/Y') }}</td>
                    <td><span class="placa-badge">{{ $factura->vehiculo->placa ?? 'N/A' }}</span></td>
                    <td>{{ $factura->concepto }}</td>
                    <td class="monto">$ {{ number_format($factura->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="estado-badge estado-{{ strtolower($factura->estado) }}">
                            {{ $factura->estado }}
                        </span>
                    </td>
                    <td>
                        <div class="acciones-tabla" style="display: flex; gap: 8px; align-items: center;">
                            @if($factura->estado == 'Pendiente')
                                <button class="btn-pagar btn-cambiar-estado" data-id="{{ $factura->id }}" data-estado="Pagada">
                                    <i class="fa-solid fa-check"></i> Pagar
                                </button>
                            @endif
                            
                            <a href="{{ url('/facturacion/'.$factura->id.'/pdf') }}" target="_blank" style="background-color: #3498db; color: white; border: none; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 5px; transition: 0.3s;">
                                <i class="fa-solid fa-file-pdf"></i> Imprimir
                            </a>

                            <form action="{{ url('/facturacion/'.$factura->id) }}" method="POST" class="form-eliminar" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 16px;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">No hay facturas registradas en el sistema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="modal-overlay" id="modal-nueva-factura">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Generar Factura Agrupada</h2>
                <button class="btn-cerrar-modal cerrar-modal-btn"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form action="{{ url('/facturacion') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-grupo">
                        <label>Vehículo con Servicios Pendientes</label>
                        <select name="vehiculo_id" id="select_vehiculo_facturar" required>
                            <option value="" disabled selected data-precio="" data-concepto="">Seleccione una placa...</option>
                            @foreach($serviciosAgrupados as $agrupado)
                                <option value="{{ $agrupado->vehiculo_id }}" data-precio="{{ $agrupado->precio_sugerido }}" data-concepto="{{ $agrupado->descripcion }}">
                                    [{{ $agrupado->placa }}] - {{ \Illuminate\Support\Str::limit($agrupado->descripcion, 50) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-grupo">
                        <label>Concepto Completo (Editable)</label>
                        <textarea name="concepto" id="concepto_factura" rows="3" required></textarea>
                    </div>
                    <div class="form-grupo">
                        <label>Total a Cobrar ($)</label>
                        <input type="number" name="total" id="total_factura" placeholder="Ej: 355000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancelar cerrar-modal-btn">Cancelar</button>
                    <button type="submit" class="btn-guardar">Generar Factura</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.cerrar-modal-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('modal-nueva-factura').classList.remove('activo');
        });
    });

    document.getElementById('btn-abrir-modal-nuevo').addEventListener('click', () => {
        document.getElementById('modal-nueva-factura').classList.add('activo');
    });

    document.getElementById('select_vehiculo_facturar').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        const precio = option.getAttribute('data-precio');
        const concepto = option.getAttribute('data-concepto');
        
        document.getElementById('concepto_factura').value = concepto;
        document.getElementById('total_factura').value = (precio && precio > 0) ? precio : '';
    });

    document.querySelectorAll('.btn-cambiar-estado').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nuevoEstado = this.getAttribute('data-estado');

            if (!confirm('¿Confirmas que el cliente ya realizó el pago de esta factura?')) return;

            fetch(`/facturacion/${id}/estado`, {
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

    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            if(!confirm('¿Estás seguro de anular esta factura? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection