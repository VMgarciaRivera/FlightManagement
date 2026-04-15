<?php
class User {
    public function __construct(
        private string $id,
        private string $email,
        private string $password // Hash de la contraseña
    ) {}

    public function id(): string { return $this->id; }
    public function email(): string { return $this->email; }

    // Método crucial: verifica si el password plano coincide con el hash
    public function verifyPassword(string $plainPassword): bool {
        return password_verify($plainPassword, $this->password);
    }
}