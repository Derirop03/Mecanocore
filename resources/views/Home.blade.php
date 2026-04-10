<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - MecanoCore</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style_home.css') }}">
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

    <section class="hero-section animado">
        <div class="hero-content">
            <h1>Revoluciona la gestión de tu taller mecánico</h1>
            <p>La plataforma definitiva para optimizar tiempos, controlar inventarios y fidelizar a tus clientes. Todo en un solo lugar.</p>
            <a href="{{ url('/login') }}" class="btn-empezar">Comenzar ahora</a>
        </div>
    </section>

    <section class="seccion_beneficios">
        <div class="texto_quienessomos">
            
            <div class="textcuadro animado">
                <h2>Control Total en Tiempo Real</h2>
                <p>Supervisa el estado de cada vehículo, asigna tareas a tus mecánicos y mantén a tus clientes informados con actualizaciones automáticas.</p>
            </div>
            
            <div class="columna-derecha animado retraso-1">
                <img src="https://images.unsplash.com/photo-1517524008697-84bbe3c3fd98?q=80&w=2070&auto=format&fit=crop" alt="Taller mecánico organizado" class="img1">
            </div>

            <div class="text_servicios animado">
                <h2>Facturación e Inventario</h2>
                <p>Genera cotizaciones precisas en segundos. Nuestro sistema descuenta automáticamente los repuestos utilizados y te alerta cuando el stock es bajo.</p>
            </div>
            
            <div class="columna-derecha animado">
                <img src="https://images.unsplash.com/photo-1503376712344-60c7b4c8038b?q=80&w=2070&auto=format&fit=crop" alt="Herramientas y diagnóstico" class="img1">
            </div>

        </div>
    </section>

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

    <script>
        const observador = new IntersectionObserver((entradas) => {
            entradas.forEach(entrada => {   
                if(entrada.isIntersecting){
                    entrada.target.classList.add('mostrar');
                }
            });
        });

        const elementosOcultos = document.querySelectorAll('.animado');
        elementosOcultos.forEach((el) => observador.observe(el));
    </script>
</body>
</html>