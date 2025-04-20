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

        .appointment-code {
            font-size: 18px;
            font-weight: bold;
            color: #66a499;
            text-align: center;
            padding: 10px;
            background-color: #f1f7f6;
            border-radius: 4px;
            margin: 20px 0;
            letter-spacing: 1px;
        }

        .map-container {
            margin: 20px 0;
            text-align: center;
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

        .button {
            background-color: #66a499;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 15px 0;
            font-weight: bold;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
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
            <p>Estimado/a tutor/a <strong>{{ $patient->tutor_name }}</strong>,</p>

            <p>La cita en la <strong>Clínica Universitaria de Visión y Optometría</strong> para su tutelado/a
                <strong>{{ $patient->name }} {{ $patient->surnames ?? '' }}</strong> ha sido confirmada con éxito. A
                continuación encontrará los detalles de la cita:
            </p>

            <div class="appointment-info">
                <p><strong>Paciente:</strong> {{ $patient->name }} {{ $patient->surnames ?? '' }}</p>
                <p><strong>Fecha:</strong> {{ date('d/m/Y', strtotime($date_appointment)) }}</p>
                <p><strong>Hora:</strong> {{ date('H:i', strtotime($time_slot->start_time)) }} -
                    {{ date('H:i', strtotime($time_slot->end_time)) }}</p>
                <p><strong>Lugar:</strong> Hospital San Rafael</p>
                <p><strong>Dirección:</strong> Calle San Juan de Dios, 19, centro, 18001 Granada</p>
            </div>

            <p>El código de cita es:</p>
            <div class="appointment-code">
                LKJKLSJDSJDALSJD
            </div>

            <p><strong>Recomendaciones para la cita del menor:</strong></p>
            <ul>
                <li>Por favor, llegue 10 minutos antes de la cita.</li>
                <li>Traiga consigo el DNI o documento de identificación del menor y el suyo propio como tutor.</li>
                <li>Si el menor utiliza gafas o lentes de contacto, tráigalos a la consulta.</li>
                <li>Como tutor legal, su presencia será requerida durante la consulta.</li>
                <li>Si necesita cancelar o reprogramar la cita, hágalo con al menos 24 horas de antelación.</li>
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
