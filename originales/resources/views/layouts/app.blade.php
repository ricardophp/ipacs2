<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Medicview') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @livewireStyles
    @stack('css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireScripts
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif


        <!-- Page Content -->
        {{-- <main>
            <div class="overflow-x-auto">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main> --}}

        <main>
            {{-- <div class="flex flex-col overflow-auto"> --}}
            {{ $slot }}
            {{-- </div> --}}
        </main>

    {{-- @stack('modals') --}}
    <script>
        livewire.on('alert',function($mensaje){
            alert($mensaje)
        })
    </script>
    <script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('copiarTexto', function(tempInput) {
            // Agrega el elemento temporal al DOM para que esté disponible para copiar
            document.body.insertAdjacentHTML('beforeend', tempInput);

            // Selecciona el contenido del elemento temporal (input)
            const input = document.getElementById('temp-input');
            input.select();

            // Ejecuta el comando de copiado al portapapeles
            document.execCommand('copy');

            // Remueve el elemento temporal del DOM
            input.remove();

            // Puedes mostrar una notificación o mensaje de éxito si lo deseas
           // alert('Texto copiado al portapapeles');
        });
    });
    </script>
    </div>



</body>
</html>
