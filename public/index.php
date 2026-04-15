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

$controller = new VueloController($container);

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? '/';

// Separamos la ruta por "/" para detectar IDs: /vuelos/123-abc
$pathParts = explode('/', trim($path, '/'));

if ($pathParts[0] === 'vuelos') {
    
    // GET /vuelos -> Listar
    if ($method === 'GET' && !isset($pathParts[1])) {
        $controller->list();
    } 
    
    // POST /vuelos -> Crear
    elseif ($method === 'POST') {
        $controller->create();
    } 
    
    // DELETE /vuelos/{id} -> Eliminar
    elseif ($method === 'DELETE' && isset($pathParts[1])) {
        $controller->delete($pathParts[1]);
    }
    
    // PUT /vuelos/{id} -> EDITAR
    elseif ($method === 'PUT' && isset($pathParts[1])) {
        $controller->update($pathParts[1]);
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}