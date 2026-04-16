<?php
class LoginService {
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(string $email, string $password): string {
    $user = $this->repository->findByEmail($email);

    if ($user && $user->verifyPassword($password)) {
        // Generamos un token aleatorio seguro
        $token = bin2hex(random_bytes(32));
        
        // Lo guardamos en el repositorio
        $this->repository->updateToken($user->id(), $token);
        
        return $token;
    }

    throw new Exception("Credenciales incorrectas.");
}
}