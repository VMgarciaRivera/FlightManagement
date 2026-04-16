<?php
class ResetPasswordService {
    public function __construct(private UserRepository $repository) {}

    public function execute(string $token, string $newPassword): void {
        $user = $this->repository->findByResetToken($token);
        
        if (!$user) {
            throw new Exception("Token de recuperación inválido.");
        }

        // Hasheamos la nueva contraseña
        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
        
        // Actualizamos la clave y BORRAMOS el token de recuperación (para que no se use de nuevo)
        $this->repository->updatePassword($user->id(), $newHash);
        $this->repository->updateResetToken($user->id(), null);
    }
}