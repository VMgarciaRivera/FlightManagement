<?php
class VueloEstadoEnum {
    public const PROGRAMADO = 'PROGRAMADO';
    public const EN_VUELO = 'EN_VUELO';
    public const REALIZADO = 'REALIZADO';
    public const CANCELADO = 'CANCELADO';
    public const RETRASADO = 'RETRASADO';

    private static array $values = [
        self::PROGRAMADO,
        self::EN_VUELO,
        self::REALIZADO,
        self::CANCELADO,
        self::RETRASADO,
    ];

    public static function values(): array {
        return self::$values;
    }

    public static function isValid(string $value): bool {
        return in_array($value, self::$values);
    }

    public static function ensureIsValid(string $value): void {
        if (!self::isValid($value)) {
            throw InvalidVueloArgumentException::because("El estado '$value' no es un estado de vuelo válido.");
        }
    }
}