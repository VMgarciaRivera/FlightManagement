<?php
class MailEmailSender implements EmailSenderInterface {
    public function sendPasswordReset(string $to, string $resetLink): void {
        $message = "Hola, usa este link para cambiar tu clave: " . $resetLink;
        
        // lo guardo primero en el log para pruebas ya que el envio de correos depende de donde desplgue el servidor
        error_log("CORREO ENVIADO A $to: $message");
        
        // Intentao envío real (funcionará si el servidor desplegado lo permite)
        $headers = "From: no-reply@sistema-vuelos.com";
        @mail($to, "Recuperar Contraseña", $message, $headers);
    }
}