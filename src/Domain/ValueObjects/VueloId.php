<?php
class VueloId {
    private string $value;

    public function __construct(string $value) {
        $this->ensureIsValidUuid($value);
        $this->value = $value;
    }

    private function ensureIsValidUuid(string $value): void {
        // Validación simple de formato UUID o longitud para VARCHAR(36)
        if (strlen($value) !== 36) {
            throw InvalidVueloArgumentException::because("El ID del vuelo debe ser un UUID válido de 36 caracteres.");
        }
    }

    public function value(): string {
        return $this->value;
    }

    public static function random(): self {
        return new self(bin2hex(random_bytes(18))); // Generador simple para el ejemplo
    }
}