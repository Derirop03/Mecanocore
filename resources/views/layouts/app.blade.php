<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') - MecanoCore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('css')
    
    <style>
        .btn-cerrar {
            background-color: transparent;
            border: none;
            color: #e74c3c;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 25px;
            transition: 0.3s;
            width: 100%;
            text-align: left;
        }

        .btn-cerrar:hover {
            background-color: rgba(255,255,255,0.05);
            color: #ff6b6b;
        }

        @media (max-width: 768px) {
            .contenedor-sistema {
                flex-direction: column !important;
            }

            .sidebar {
                width: 100% !important;
                height: auto !important;
                position: relative !important;
                flex-direction: row !important;
                align-items: center !important;
                padding: 10px !important;
                overflow-x: auto !important;
                white-space: nowrap !important;
                z-index: 1000 !important;
                box-sizing: border-box !important;
            }

            .sidebar-header {
                border-bottom: none !important;
                border-right: 1px solid rgba(255,255,255,0.1) !important;
                padding-right: 15px !important;
                margin-right: 15px !important;
                height: auto !important;
            }

            .sidebar-header h2 {
                display: none !important;
            }

            .sidebar-menu {
                flex-direction: row !important;
                padding: 0 !important;
                gap: 5px !important;
                flex: 1 !important;
            }

            .menu-item {
                padding: 10px 15px !important;
                border-left: none !important;
                border-bottom: 3px solid transparent !important;
            }

            .menu-item.activo {
                border-bottom-color: #32E0C4 !important;
                background-color: transparent !important;
            }

            .menu-item span {
                display: none !important;
            }

            .menu-item i {
                font-size: 18px !important;
                margin: 0 !important;
                width: auto !important;
            }

            .sidebar-footer {
                padding: 0 0 0 15px !important;
                border-top: none !important;
                border-left: 1px solid rgba(255,255,255,0.1) !important;
                margin-left: auto !important;
            }

            .btn-cerrar {
                padding: 10px !important;
                width: auto !important;
                font-size: 18px !important;
            }

            .btn-cerrar span {
                display: none !important;
            }

            .contenido-principal {
                margin-left: 0 !important;
                padding: 20px 15px !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor-sistema">
        
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-icon-small">
                    <i class="fa-solid fa-wrench"></i>
                </div>
                <h2>MecanoCore</h2>
            </div>

           <nav class="sidebar-menu">
                <a href="{{ url('/sistema') }}" class="menu-item {{ request()->is('sistema') ? 'activo' : '' }}">
                    <i class="fa-solid fa-bolt"></i>
                    <span>Dashboard</span>
                </a>

                @if(in_array(Auth::user()->rol, ['admin', 'mecanico', 'secretario', 'lavador']))
                <a href="{{ url('/vehiculos') }}" class="menu-item {{ request()->is('vehiculos') ? 'activo' : '' }}">
                    <i class="fa-solid fa-car"></i>
                    <span>Vehículos</span>
                </a>
                @endif

                @if(in_array(Auth::user()->rol, ['admin', 'mecanico', 'secretario']))
                <a href="{{ url('/taller') }}" class="menu-item {{ request()->is('taller') ? 'activo' : '' }}">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span>Taller Mecánico</span>
                </a>
                @endif

                @if(in_array(Auth::user()->rol, ['admin', 'lavador', 'secretario']))
                <a href="{{ url('/lavadero') }}" class="menu-item {{ request()->is('lavadero') ? 'activo' : '' }}">
                    <i class="fa-solid fa-droplet"></i>
                    <span>Lavadero</span>
                </a>
                @endif

                @if(in_array(Auth::user()->rol, ['admin', 'cajero', 'secretario']))
                <a href="{{ url('/facturacion') }}" class="menu-item {{ request()->is('facturacion') ? 'activo' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>Facturación</span>
                </a>
                @endif

                <a href="{{ url('/historial') }}" class="menu-item {{ request()->is('historial') ? 'activo' : '' }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Historial</span>
                </a>
                
                @if(Auth::user()->rol === 'admin')
                <a href="{{ url('/usuarios') }}" class="menu-item {{ request()->is('usuarios') ? 'activo' : '' }}">
                    <i class="fa-solid fa-users-gear"></i>
                    <span>Usuarios</span>
                </a>
                @endif
            </nav>
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-cerrar" title="Cerrar Sesión">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="contenido-principal">
            @yield('contenido')
        </main>
    </div>

    @yield('scripts')
</body>
</html>