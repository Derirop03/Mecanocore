@extends('layouts.app')

@section('titulo', 'Gestión de Usuarios')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/style_sistema.css') }}">
@endsection

@section('contenido')
    <header class="topbar">
        <div class="titulo-seccion">
            <h1>Gestión de Usuarios</h1>
            <p>Administración del personal y accesos</p>
        </div>
        <div class="acciones-topbar">
            <button class="btn-nuevo" id="btn-abrir-modal">
                <i class="fa-solid fa-user-plus"></i> Nuevo Usuario
            </button>
        </div>
    </header>

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}
        </div>
    @endif

    <div class="contenedor-tabla">
        <table class="tabla-vehiculos" style="width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <thead style="background-color: #212121; color: white; text-align: left;">
                <tr>
                    <th style="padding: 15px;">Nombre Completo</th>
                    <th style="padding: 15px;">Usuario</th>
                    <th style="padding: 15px;">Rol</th>
                    <th style="padding: 15px;">Email</th>
                    <th style="padding: 15px; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $user)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px;">{{ $user->name }}</td>
                        <td style="padding: 15px; font-weight: bold; color: #0D7377;">{{ $user->username }}</td>
                        <td style="padding: 15px;">
                            <span style="background-color: {{ $user->rol == 'admin' ? '#e74c3c' : ($user->rol == 'cajero' ? '#f39c12' : ($user->rol == 'lavador' ? '#00b894' : ($user->rol == 'secretario' ? '#8e44ad' : '#3498db'))) }}; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: capitalize;">
                                {{ $user->rol }}
                            </span>
                        </td>
                        <td style="padding: 15px;">{{ $user->email }}</td>
                        <td style="padding: 15px; display: flex; justify-content: center; gap: 10px;">
                            
                            <form action="{{ url('/usuarios/'.$user->id.'/reset') }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" style="background: none; border: none; color: #f39c12; cursor: pointer; font-size: 18px;" title="Restablecer Contraseña (12345678)" onclick="return confirm('¿Restablecer la contraseña de este usuario a 12345678?')">
                                    <i class="fa-solid fa-key"></i>
                                </button>
                            </form>

                            @if(Auth::id() != $user->id)
                            <form action="{{ url('/usuarios/'.$user->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 18px;" title="Eliminar Usuario" onclick="return confirm('¿Estás seguro de eliminar este usuario del sistema?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal-overlay" id="modal-nuevo-usuario" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; opacity: 0; visibility: hidden; transition: 0.3s; z-index: 2000;">
        <div class="modal-content" style="background: white; padding: 30px; border-radius: 12px; width: 500px; max-width: 90%;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h2 style="margin: 0; color: #333;">Registrar Empleado</h2>
                <button type="button" class="btn-cerrar-modal" style="background: none; border: none; font-size: 20px; color: #999; cursor: pointer;"><i class="fa-solid fa-xmark"></i></button>
            </div>
            
            <form action="{{ url('/usuarios') }}" method="POST">
                @csrf
                <div style="margin-bottom: 25px;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Nombre Completo</label>
                        <input type="text" name="name" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Usuario Login</label>
                            <input type="text" name="username" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Rol en el Sistema</label>
                            <select name="rol" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                                <option value="mecanico">Mecánico (Taller)</option>
                                <option value="lavador">Lavador (Lavadero)</option>
                                <option value="cajero">Cajero (Facturación)</option>
                                <option value="secretario">Secretario (Recepción)</option>
                                <option value="admin">Administrador (Total)</option>
                            </select>
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Correo Electrónico</label>
                        <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Contraseña Inicial</label>
                        <input type="password" name="password" required minlength="8" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                    </div>
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                    <button type="button" class="btn-cerrar-modal" style="padding: 10px 20px; border-radius: 6px; border: 1px solid #ddd; background: white; cursor: pointer; font-weight: 600;">Cancelar</button>
                    <button type="submit" style="padding: 10px 20px; border-radius: 6px; border: none; background: #0D7377; color: white; cursor: pointer; font-weight: 600;">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('modal-nuevo-usuario');
    
    document.getElementById('btn-abrir-modal').addEventListener('click', () => {
        modal.style.opacity = '1';
        modal.style.visibility = 'visible';
    });

    document.querySelectorAll('.btn-cerrar-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            modal.style.opacity = '0';
            modal.style.visibility = 'hidden';
        });
    });
</script>
@endsection