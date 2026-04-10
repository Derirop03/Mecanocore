<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MecanoCore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
</head>
<body>
    <nav>
        <a href="{{ url('/') }}" class="logo">MecanoCore</a>
        <div class="grupo-botones">
            <a href="{{ url('/') }}" class="home-item">Home</a>
            <a href="{{ url('/nosotros') }}" class="welcome-item">¿Quienes somos?</a>
            <a href="{{ url('/login') }}" class="login-item">Login</a>
        </div>
    </nav>

    <div class="login-wrapper">   
        <div class="login-card">
            <h2>Bienvenido</h2>
            <p>Ingresa tus credenciales para continuar</p>

            @if(session('mensaje'))
                <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; text-align: center;">
                    {{ session('mensaje') }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="grupo-input">
                    <label>Usuario</label>
                    <input type="text" name="username" placeholder="Ej: admin" value="{{ old('username') }}" required>
                    @error('username')
                        <span style="color: #e74c3c; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grupo-input">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="********" required>
                </div>

                <button type="submit" class="btn-login">Ingresar</button>
            </form>

            <a href="{{ url('/') }}" class="link-volver">Volver al inicio</a>
        </div>
    </div>

    <footer class="pie-pagina">
        <div class="contenedor-footer">
            <div class="footer-col">
                <h3>MecanoCore</h3>
                <p>La solución digital para el taller moderno. Simplificamos tu gestión para que tú solo te preocupes por reparar.</p>
            </div>

            <div class="footer-col">
                <h4>Explorar</h4>
                <a href="{{ url('/') }}">Inicio</a>
                <a href="#">Soporte Técnico</a>
            </div>

            <div class="footer-col">
                <h4>Contacto</h4>
                <p><i class="fa-solid fa-location-dot"></i> Bogotá, Colombia</p>
                <p><i class="fa-solid fa-envelope"></i> contacto@mecanocore.com</p>
                <p><i class="fa-solid fa-phone"></i> +57 300 123 4567</p>
                
                <div class="redes-sociales">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2025 MecanoCore. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>