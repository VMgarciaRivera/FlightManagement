<?php
class AuthController {
    public function __construct(private DependencyContainer $container) {}

    public function login(): void {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {
            $service = $this->container->getLoginService();
            $user = $service->execute($data['email'], $data['password']);

            // Aquí se podría iniciar una sesión de PHP si me da la gana, o generar un token JWT para autenticación stateless
            session_start();
            $_SESSION['user_id'] = $user->id();

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success', 
                'message' => 'Bienvenido',
                'user' => $user->email()
            ]);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}