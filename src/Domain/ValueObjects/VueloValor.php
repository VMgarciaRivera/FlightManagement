<?php
class VueloValor {
    private float $value;

    public function __construct(float $value) {
        if ($value < 0) {
            throw InvalidVueloArgumentException::because("El valor del vuelo no puede ser negativo.");
        }
        $this->value = $value;
    }

    public function value(): float {
        return $this->value;
    }
}