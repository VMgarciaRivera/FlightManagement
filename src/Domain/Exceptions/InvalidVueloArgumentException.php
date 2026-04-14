<?php
//excepción general para cuando un dato del vuelo sea inválido.
class InvalidVueloArgumentException extends Exception {
    public static function because(string $message): self {
        return new self($message);
    }
}