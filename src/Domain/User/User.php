<?php
class User {
    public function __construct(
        private string $id,
        private string $email,
        private string $password, // Hash de la contraseña
        private ?string $token = null, // Token de sesión (nullable)
        private ?string $resetToken = null // Token de recuperación (nullable)

    ) {}

    public function id(): string { return $this->id; }
    public function email(): string { return $this->email; }
    public function token(): ?string { return $this->token; }
    public function resetToken(): ?string { return $this->resetToken; }

    // Método crucial: verifica si el password plano coincide con el hash
    public function verifyPassword(string $plainPassword): bool {
        return password_verify($plainPassword, $this->password);
    }
}