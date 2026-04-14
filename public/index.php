<?php
// 1. Requerimos los archivos base de la carpeta Common
require_once __DIR__ . '/../src/Common/Classloader.php';
require_once __DIR__ . '/../src/Common/DependencyContainer.php';

// 2. Configuramos y registramos el Autocargador
// Agregamos todas las rutas donde tenemos clases
$loader = new ClassLoader([
    __DIR__ . '/../src/Domain',
    __DIR__ . '/../src/Application',
    __DIR__ . '/../src/Infrastructure',
    __DIR__ . '/../src/Common'
]);
$loader->register();

// 3. Inicializamos el Contenedor de Dependencias
$container = new DependencyContainer();

// --- PRUEBA DE INSERCIÓN ---
try {
    // Obtenemos el servicio desde el contenedor
    $createService = $container->getCreateVueloService();

    // Simulamos datos que vendrían de un formulario
    $datosVuelo = [
        'id' => '550e8400-e29b-41d4-a716-446655440000', // Un UUID de ejemplo
        'fechaCompra' => '2026-04-14',
        'fechaSalida' => '2026-04-15 10:00:00',
        'fechaLlegada' => '2026-04-15 13:00:00',
        'agenciaViajes' => 'Viajes Éxito',
        'aerolinea' => 'Avianca',
        'numero' => 'AV123',
        'estado' => 'PROGRAMADO', // Debe coincidir con tu VueloEstadoEnum
        'valor' => 150.50,
        'cliente' => 'Juan Perez',
        'puesto' => '12A',
        'avion' => 'Airbus A320',
        'aeropuertoSalida' => 'SKBO',
        'aeropuertoLlegada' => 'SKRG',
        'piloto' => 'Cap. Mauricio Arango'
    ];

    // Creamos el comando y ejecutamos el servicio
    $command = new CreateVueloCommand($datosVuelo);
    $createService->execute($command);

    echo "¡Vuelo creado con éxito!";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}