<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        p {
            color: #333;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:visited {
            color: blue;
            text-decoration: none;
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

        .appointment-info {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #66a499;
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
            <h1>Confirmación de Cita</h1>
        </div>

        <!-- Contenido -->
        <div class="content">
            <p>Estimado/a <strong>{{ $patient->name }} {{ $patient->surnames }}</strong>,</p>

            <p>Su cita en la <strong>Clínica Universitaria de Visión y Optometría</strong> ha sido confirmada con éxito.
                A continuación encontrará los detalles de su cita:</p>

            <div class="appointment-info">
                <p><strong>Paciente:</strong> {{ $patient->name }} {{ $patient->surnames }}</p>
                <p><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($date_appointment)) }} </p>
                <p><strong>Hora de la cita:</strong> {{ date('H:i', strtotime($time_slot->start_time)) }}</p>
                <p><strong>Sala:</strong> {{ $appointment->user->office->name }}</p>
                <p><strong>Lugar:</strong> Hospital San Rafael</p>
                <p><strong>Dirección:</strong> Calle San Juan de Dios, 19, centro, 18001 Granada</p>
            </div>

            <p>Si desea cancelar su cita, haga clic en el siguiente enlace:
                <a href="{{ $cancel_url }}">Cancelar Cita</a>
            </p>

            <p><strong>Recomendaciones:</strong></p>
            <ul>
                <li>Por favor, llegue 10 minutos antes de su cita.</li>
                <li>Traiga consigo su DNI o documento de identificación.</li>
                <li>Si utiliza gafas o lentes de contacto, tráigalos a la consulta.</li>
                <li>Si necesita cancelar o reprogramar su cita, hágalo con al menos 24 horas de antelación.</li>
            </ul>

            <p>Si tiene alguna pregunta o necesita más información, no dude en contactarnos en el siguiente enlace:<a
                    href="{{ config('app.url') }}/contact"> Contacto</a></p>
            <p>¡Gracias por confiar en nosotros!</p>
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
