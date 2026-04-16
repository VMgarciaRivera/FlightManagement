<?php
interface EmailSenderInterface {
    public function sendPasswordReset(string $to, string $resetLink): void;
}