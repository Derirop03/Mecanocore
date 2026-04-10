<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket de Caja</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 14px; color: #333; }
        .cabecera { text-align: center; margin-bottom: 30px; }
        .cabecera h1 { margin: 0; color: #0D7377; font-size: 24px; }
        .cabecera p { margin: 5px 0; font-size: 12px; color: #666; }
        .info-factura { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .info-factura td { padding: 5px; }
        .tabla-servicios { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .tabla-servicios th { background-color: #212121; color: white; padding: 10px; text-align: left; }
        .tabla-servicios td { padding: 10px; border-bottom: 1px solid #ddd; }
        .totales { width: 100%; border-collapse: collapse; }
        .totales td { padding: 10px; text-align: right; }
        .total-final { font-size: 18px; font-weight: bold; color: #0D7377; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; color: #999; border-top: 1px solid #ddd; padding-top: 20px; }
    </style>
</head>
<body>

    <div class="cabecera">
        <h1>MecanoCore</h1>
        <p>Taller y Centro de Lavado Automotriz</p>
        <p>NIT: 900.123.456-7 | Bogotá, Colombia</p>
        <p>Ticket de Servicio #{{ str_pad($factura->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>

    <table class="info-factura">
        <tr>
            <td><strong>Fecha:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</td>
            <td style="text-align: right;"><strong>Placa del Vehículo:</strong> {{ $factura->placa ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="tabla-servicios">
        <thead>
            <tr>
                <th>Descripción del Servicio</th>
                <th style="text-align: right;">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Servicios prestados (Taller / Lavadero)</td>
                <td style="text-align: right;">$ {{ number_format($factura->total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <table class="totales">
        <tr>
            <td>Subtotal:</td>
            <td style="width: 150px;">$ {{ number_format($factura->total / 1.19, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>IVA (19%):</td>
            <td>$ {{ number_format($factura->total - ($factura->total / 1.19), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="total-final">TOTAL A PAGAR:</td>
            <td class="total-final">$ {{ number_format($factura->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>¡Gracias por confiar en MecanoCore!</p>
        <p>Este documento es un soporte de pago equivalente a factura electrónica.</p>
    </div>

</body>
</html>