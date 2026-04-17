<?php

require_once __DIR__ . '/src/Infrastructure/Config/EnvLoader.php';
// Se Cargan las variables de entorno desde la raíz
$envPath = __DIR__ . '/.env';

if (file_exists($envPath)) {
    EnvLoader::load($envPath);
}

// 1. Requerimos los archivos base de la carpeta Common
require_once __DIR__ . '/src/Common/Classloader.php';
require_once __DIR__ . '/src/Common/DependencyContainer.php';

/*
  Verifica que el token enviado sea válido.
 */
function authenticate(DependencyContainer $container): void {
    //Obtener todos los encabezados de la petición
    $headers = getallheaders();
    
    //Buscar el encabezado Authorization (puede ser con A mayúscula o minúscula)
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

    if (!$authHeader) {
        http_response_code(401);
        echo json_encode(['error' => 'No se proporciono un token de seguridad.']);
        exit;
    }

    //Extraer el token del formato "Bearer <token>"
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
        
        //Consultar en la base de datos a través del repositorio
        $userRepo = $container->getUserRepository();
        $user = $userRepo->findByToken($token);

        if ($user) {
            // Token válido. El código continúa su ejecución normal.
            return;
        }
    }

    // Si el token no es válido o no tiene el formato correcto
    http_response_code(401);
    echo json_encode(['error' => 'Token inválido o expirado.']);
    exit;
}

// 2. Configuramos y registramos el Autocargador
// Agregamos todas las rutas donde tenemos clases
$loader = new ClassLoader([
    __DIR__ . '/src/Domain',
    __DIR__ . '/src/Application',
    __DIR__ . '/src/Infrastructure',
    __DIR__ . '/src/Common'
]);
$loader->register();

// 3. Inicializamos el Contenedor de Dependencias
$container = new DependencyContainer();

$controller = new VueloController($container);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Separamos la ruta por "/" para detectar IDs: /vuelos/123-abc
$pathParts = explode('/', trim($path, '/'));

//post para login
if ($pathParts[0] === 'login' && $method === 'POST') {
    $authController = new AuthController($container);
    $authController->login();
    exit;
}

//post para logout
if ($pathParts[0] === 'logout' && $method === 'POST') {
    $authController = new AuthController($container);
    $authController->logout();
    exit;
}

// Pedir el cambio de contraseña
if ($pathParts[0] === 'forgot-password' && $method === 'POST') {
    $authController = new AuthController($container);
    $authController->forgotPassword();
    exit;
}

//Ejecutar el cambio de contraseña
if ($pathParts[0] === 'reset-password' && $method === 'POST') {
    $authController = new AuthController($container);
    $authController->resetPassword();
    exit;
}

if ($pathParts[0] === 'vuelos') {

    authenticate($container); // Verificamos el token antes de permitir cualquier acción en vuelos

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
