<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mecanocore - Nuevo Ingreso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #212121;
            --teal-dark: #0D7377;
            --teal-light: #32E0C4;
            --white-off: #EEEEEE;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .card {
            background-color: var(--white-off);
            border: none;
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(50, 224, 196, 0.15);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }

        .card-header {
            background-color: var(--teal-dark);
            color: var(--white-off);
            border-bottom: none;
            padding: 25px;
            text-align: center;
        }

        .card-header h3 {
            font-weight: 600;
            letter-spacing: 1px;
            margin: 0;
        }

        .card-body {
            padding: 40px;
        }

        .form-label {
            color: var(--bg-dark);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .form-control {
            background-color: #fff;
            border: 2px solid transparent;
            border-radius: 15px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            color: var(--bg-dark);
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--teal-light);
            box-shadow: 0 0 0 4px rgba(50, 224, 196, 0.1);
        }

        .btn-submit {
            background-color: var(--teal-dark);
            color: var(--white-off);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(13, 115, 119, 0.3);
        }

        .btn-submit:hover {
            background-color: var(--teal-light);
            color: var(--bg-dark);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 15px;
            border: none;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <h3>Ingreso de Vehículo</h3>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form action="{{ route('guardar.vehiculo') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="placa" class="form-label">Placa del Vehículo</label>
                    <input type="text" name="placa" id="placa" class="form-control" placeholder="Ej: ABC-123" required>
                </div>

                <div class="mb-4">
                    <label for="marca" class="form-label">Marca y Modelo</label>
                    <input type="text" name="marca" id="marca" class="form-control" placeholder="Ej: Toyota Corolla" required>
                </div>

                <div class="mb-4">
                    <label for="falla" class="form-label">Descripción de la Falla</label>
                    <textarea name="descripcion_falla" id="falla" class="form-control" rows="4" placeholder="Detalle el problema..." required></textarea>
                </div>
                
                <button type="submit" class="btn btn-submit">Registrar Ingreso</button>
            </form>
        </div>
    </div>

</body>
</html>