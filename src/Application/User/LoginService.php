<?php
class LoginService {
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(string $email, string $password): ?User {
        $user = $this->repository->findByEmail($email);

        if ($user && $user->verifyPassword($password)) {
            return $user;
        }

        throw new Exception("Credenciales incorrectas.");
    }
}