<?php
class AuthController
{
    public function __construct(private DependencyContainer $container) {}

    public function login(): void
    {
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

    public function logout(): void
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
        
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
            $repo = $this->container->getUserRepository();
            $user = $repo->findByToken($token);

            if ($user) {
                // Usamos updateToken con null para invalidar la sesión
                $repo->updateToken($user->id(), null);
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['message' => 'Sesión cerrada exitosamente']);
    }

    // dejo listo el espacio para el forgotPassword que hare luego
    public function forgotPassword(): void
    {
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
    }

    public function resetPassword(): void
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {
            // Validamos que vengan los datos necesarios
            if (!isset($data['token']) || !isset($data['new_password'])) {
                throw new Exception("Token y nueva contraseña son requeridos.");
            }

            $service = $this->container->getResetPasswordService();
            $service->execute($data['token'], $data['new_password']);

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'message' => 'Contraseña actualizada correctamente. Por favor, inicia sesión de nuevo.'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
