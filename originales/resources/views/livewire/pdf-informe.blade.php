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
                width:auto;
                height: auto;
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

            .caja {
                width: 600px;  /* Ancho deseado de la caja */
                height:auto /* Altura deseada de la caja */
                border: 1px solid black;/* Borde de la caja */
                padding: 10px; /* Espacio interno de la caja */
                overflow: auto; /* Habilita la barra de desplazamiento cuando el texto excede el tamaño de la caja */
                word-wrap: break-word; /* Hace que el texto se ajuste automáticamente al ancho de la caja */
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
                    <strong>Paciente:</strong>{{ $estudio[0]['00100010']['Value'][0]['Alphabetic'] }}
                </li>
                <li style="line-height: 2;"><strong>Obra Social:</strong>{{ $series[0]['00081040']['Value'][0] }} </li>
                <li style="line-height: 2;"><strong>Medico: </strong> </li>
                <li style="line-height: 2;"><strong>Estudio:</strong> </li>
                <li style="line-height: 2;"><strong>Fecha Estudio:</strong>{{ $estudio[0]['00080020']['Value'][0] }}
                </li>
            </ul>
            <strong>Informe:</strong>
            <div class="caja">
                <p>{!! $content !!}</p>
            </div>
        </div>
        {{-- <div class="container">
            <div class="column">
                <p><strong></strong></p>
            </div>
            <div class="column">
                <p><strong></strong></p>
            </div>
        </div> --}}
        <footer>
            <img src="storage\image\pie_informe.png" alt="Cualquier consulta no dude en llamarnos">
        </footer>
    </body>
    </html>
</div>
