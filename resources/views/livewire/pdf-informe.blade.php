<div>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <title>Informe Simed Salud</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }

            header,
            footer {
                background-color: #f2f2f2;
                padding: 10px;
                text-align: center;
            }

            .content {
                padding: 20px;
            }

            .titulo {
                text-align: center;
            }

            .item {
                text-align: left;
                text-emphasis-style: filled;
            }

            .image {
                width: 100%;
                height: 5cm;
                margin-bottom: 20px;
                object-fit: cover;
            }

            .fecha {
                text-align: right;
            }

            .container {
                display: flex;
                justify-content: center;
                line-height: 0.5;
            }

            .column {
                flex: 1;
                padding: 20px;
            }
        </style>
    </head>

    <body>
        <header>
            <img src="storage\image\cab_informe.png" alt="Simed Es Salud" class="image">
        </header>

        <div class="content">
            <div class="fecha">Resistencia,{{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
            <h2 class="titulo">Informe de {{ $estudio[0]['00080061']['Value'][0] }} perteneciente a
                {{ $estudio[0]['00100010']['Value'][0]['Alphabetic'] }}</h2>

            <ul style="list-style-type: disc;">
                <li style="line-height: 2;">
                    <strong>Paciente:</strong>{{ $estudio[0]['00100010']['Value'][0]['Alphabetic'] }} </li>
                <li style="line-height: 2;"><strong>Obra Social:</strong>{{ $series[0]['00081040']['Value'][0] }} </li>
                <li style="line-height: 2;"><strong>Medico: </strong> </li>
                <li style="line-height: 2;"><strong>Estudio:</strong> </li>
                <li style="line-height: 2;"><strong>Fecha Estudio:</strong>{{ $estudio[0]['00080020']['Value'][0] }}
                </li>

            </ul>
            <p><strong>Informe:</strong></p>
            <p>{{ $content }}</p>
        </div>
        <div class="container">
            <div class="column">
                <p><strong></strong></p>
                <p></p>
                <p></p>
            </div>
            <div class="column">
                <p><strong></strong></p>
                <p></p>
                <p></p>
            </div>
        </div>
        <footer>
            <img src="storage\image\pie_informe.png" alt="Cuanlquier consulta no dude en llamarnos" class="image">
        </footer>
    </body>

    </html>
</div>
