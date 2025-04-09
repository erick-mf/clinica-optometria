<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Mensaje de Contacto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #66a499;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 10px 0;
            font-size: 16px;
            line-height: 1.5;
        }
        .content p strong {
            color: #444;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
        .footer a {
            color: #66a499;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <h1>Nuevo Mensaje de Contacto</h1>
        </div>

        <!-- Contenido -->
        <div class="content">
            <p><strong>Nombre:</strong> {{ $name }}</p>
            <p><strong>Apellidos:</strong> {{ $surnames }}</p>
            <p><strong>Forma de contacto
                @if ($contact_method === 'email')
                    (Correo): </strong>  {{ $email }}
                @elseif ($contact_method === 'phone')
                    (Teléfono): </strong> {{ $phone }}
                @endif
            </p>
            <p><strong>Mensaje:</strong> {{ $content_message }}</p>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>Clínica Universitaria de Visión y Optometría</p>
            <p>Este mensaje fue enviado desde el formulario de contacto. <a href="https://www.ugr.es/">Visítanos</a></p>
        </div>
    </div>
</body>
</html>