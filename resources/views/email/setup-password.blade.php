<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Contraseña</title>
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

        .info-box {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #66a499;
        }

        .action-button {
            text-align: center;
            margin: 25px 0;
        }

        .button {
            background-color: #66a499;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
            font-size: 16px;
        }

        .expiry-notice {
            font-size: 14px;
            color: #777;
            text-align: center;
            margin: 20px 0;
            font-style: italic;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
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
            <h1>Configuración de Contraseña</h1>
        </div>

        <!-- Contenido -->
        <div class="content">
            <p>Hola <strong>{{ $notifiable->name }}</strong>,</p>

            <p>Has sido registrado en nuestro sistema.</p>

            <div class="info-box">
                <p>Para acceder a tu cuenta, necesitas configurar una contraseña personal siguiendo estos pasos:</p>
                <ol>
                    <li>Haz clic en el botón "Configurar contraseña" que aparece a continuación</li>
                    <li>Establece una contraseña segura para tu cuenta</li>
                    <li>Una vez configurada, podrás iniciar sesión con tu correo electrónico y contraseña</li>
                </ol>
            </div>

            <div class="action-button">
                <a href="{{ $url }}" class="button">Configurar contraseña</a>
            </div>

            <div class="expiry-notice">
                Este enlace expirará en {{ round(config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') / 60, 1) }} horas.
            </div>

            <p>Si no has solicitado esta cuenta, puedes ignorar este mensaje.</p>

            <p>Saludos,<br>
                Clínica Universitaria de Visión y Optometría</p>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>Clínica Universitaria de Visión y Optometría</p>
            <p>Universidad de Granada</p>
            <p><a href="https://www.ugr.es/">www.ugr.es</a></p>
            <p>Este es un mensaje automático, por favor no responda a este correo.</p>
        </div>
    </div>
</body>

</html>
