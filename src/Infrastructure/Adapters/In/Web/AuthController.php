<?php
class AuthController {
    public function __construct(private DependencyContainer $container) {}

    public function login(): void {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {
            $service = $this->container->getLoginService();
            
            // $token ahora recibe el string que genera el LoginService
            $token = $service->execute($data['email'], $data['password']);

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success', 
                'message' => 'Bienvenido al sistema',
                'token' => $token, // <- El cliente  usará esto para los vuelos
                'user' => $data['email']
            ]);
        } catch (Exception $e) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /* // dejo listo el espacio para el forgotPassword que hare luego
    public function forgotPassword(): void {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {
            $service = $this->container->getForgotPasswordService();
            $service->execute($data['email']);

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Si el correo existe, se ha enviado un enlace de recuperación.'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } */
}