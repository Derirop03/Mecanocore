<!DOCTYPE html>
<html lang="en">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MecanoCore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style_inicio.css') }}">
</head>
<body>
    <nav>
        <h1 class="logo">Bienvenidos a MecanoCore</h1>
        <div class="grupo-botones">
            <a href="{{ url('/home')}}"class="home-item">Home</button>
            <a href="{{ url('/') }}" class="index-item">¿Quienes somos?</a>
            <a href="{{ url('/login') }}" class="login-item">Login</a>
        </div>
    </nav>
    <section id="que_es" class="seccion_nosotros">
        

    <div class="texto_quienessomos">

        <div class="textcuadro animado">
            <h2>¿Qué es MecanoCore?</h2>
            <p>
                Somos la solución integral diseñada específicamente para optimizar la gestión de talleres mecánicos modernos. Nuestro software centraliza el control de inventario, el historial de reparaciones y la facturación en una sola plataforma intuitiva.
            </p>
            <p>
                Nuestro objetivo es eliminar el caos administrativo, permitiendo que los mecánicos se concentren en lo que mejor saben hacer: reparar vehículos, mientras nosotros cuidamos de los datos.
            </p>
        </div>

        <div class="columna-derecha animado retraso-1">
            <img src="https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?q=80&w=1974&auto=format&fit=crop" alt="Mecánico trabajando con tablet" class="img1">
        </div>

        <div class="text_servicios animado">
            <h2>Funcionalidades Clave</h2>
            <p>
                <strong>Gestión de Inventario:</strong> Control en tiempo real de repuestos y alertas de stock bajo.
            </p>
            <p>
                <strong>Historial Vehicular:</strong> Acceso inmediato a reparaciones previas, mantenimientos y garantías de cada cliente.
            </p>
            <p>
                <strong>Citas y Agenda:</strong> Organización automatizada de turnos y asignación de bahías de trabajo.
            </p>
        </div>
            
        <div class="columna-derecha animado">
            <img src="{{ asset('images/Mecanico_mecacocore.png') }}" alt="Mecánico trabajando con tablet" class="img1">
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
            <a href="#">Inicio</a>
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
    <script src="{{ asset('js/app.js') }}"></script>
</body>
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
</html>