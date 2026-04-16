<?php
// 1. Requerimos los archivos base de la carpeta Common
require_once __DIR__ . '/../src/Common/Classloader.php';
require_once __DIR__ . '/../src/Common/DependencyContainer.php';

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

//post para login
if ($pathParts[0] === 'login' && $method === 'POST') {
    $authController = new AuthController($container);
    $authController->login();
    exit;
}

//ruta para forgot password, dejo listo el espacio para luego
/* if ($pathParts[0] === 'forgot-password' && $method === 'POST') {
    $authController = new AuthController($container);
    $authController->forgotPassword();
    exit;
} */

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
