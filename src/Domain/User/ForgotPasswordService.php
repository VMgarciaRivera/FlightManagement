<?php

class ForgotPasswordService {
    public function __construct(
        private UserRepository $userRepository,
        private EmailSenderInterface $emailSender
    ) {}

    public function execute(string $email): void {
        //busco si el usuario existe
        $user = $this->userRepository->findByEmail($email);

        /*en caso de que el usuario no exista simplemente no mando error
        ni nada para evitar revelar información */
        if (!$user) {
            return; 
        }

        // Generamos un token seguro de un solo uso
        $token = bin2hex(random_bytes(20));

        //Guardamos el token en la columna reset_token de la BD
        $this->userRepository->updateResetToken($user->id(), $token);

        // se construye el enlace (esto es lo que iría al front-end o correo)
        $resetLink = "http://localhost:8000/reset-password?token=" . $token;

        // Enviamos el "correo" a través del puerto
        $this->emailSender->sendPasswordReset($user->email(), $resetLink);
    }
}