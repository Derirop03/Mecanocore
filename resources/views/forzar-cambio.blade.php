<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización Requerida</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #212121; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: sans-serif; }
        .card { background: white; padding: 40px; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); text-align: center; }
        .card h2 { color: #0D7377; margin-top: 0; }
        .card p { color: #666; font-size: 14px; margin-bottom: 25px; }
        .input-group { margin-bottom: 20px; text-align: left; }
        .input-group label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 5px; color: #333; }
        .input-group input { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; box-sizing: border-box; outline: none; transition: 0.3s; }
        .input-group input:focus { border-color: #0D7377; }
        .btn-submit { background-color: #0D7377; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; font-size: 16px; }
        .btn-submit:hover { background-color: #32E0C4; color: #212121; }
    </style>
</head>
<body>
    <div class="card">
        <i class="fa-solid fa-shield-halved" style="font-size: 50px; color: #f39c12; margin-bottom: 15px;"></i>
        <h2>Actualización Requerida</h2>
        <p>Hola, <strong>{{ Auth::user()->name }}</strong>. Estás usando la contraseña temporal por defecto. Por seguridad, debes crear una nueva clave personal para poder ingresar a MecanoCore.</p>
        
        <form action="{{ url('/forzar-cambio') }}" method="POST">
            @csrf
            <div class="input-group">
                <label>Escribe tu Nueva Contraseña</label>
                <input type="password" name="password" required minlength="8" placeholder="Mínimo 8 caracteres">
            </div>
            <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Guardar y Entrar</button>
        </form>
    </div>
</body>
</html>