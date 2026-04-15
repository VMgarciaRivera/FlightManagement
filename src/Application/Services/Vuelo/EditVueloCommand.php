<?php
class EditVueloCommand {
    public function __construct(
        private string $id,
        private string $fechaCompra,
        private string $fechaSalida,
        private string $fechaLlegada,
        private string $agenciaViajes,
        private string $aerolinea,
        private string $numero,
        private string $estado,
        private float $valor,
        private string $cliente,
        private string $puesto,
        private string $avion,
        private string $aeropuertoSalida,
        private string $aeropuertoLlegada,
        private string $piloto
    ) {}

    // Método estático para construir el comando desde un array (JSON decoded)
    public static function fromArray(array $data): self {
    return new self(
        $data['id'],
        $data['fechaCompra'],
        $data['fechaSalida'],
        $data['fechaLlegada'],
        $data['agenciaViajes'],
        $data['aerolinea'],
        $data['numero'],
        $data['estado'],
        (float)$data['valor'],
        $data['cliente'],
        $data['puesto'],
        $data['avion'],
        $data['aeropuertoSalida'],
        $data['aeropuertoLlegada'],
        $data['piloto']
    );
}

    // Getters
    public function getId(): string { return $this->id; }
    public function getFechaCompra(): string { return $this->fechaCompra; }
    public function getFechaSalida(): string { return $this->fechaSalida; }
    public function getFechaLlegada(): string { return $this->fechaLlegada; }
    public function getAgenciaViajes(): string { return $this->agenciaViajes; }
    public function getAerolinea(): string { return $this->aerolinea; }
    public function getNumero(): string { return $this->numero; }
    public function getEstado(): string { return $this->estado; }
    public function getValor(): float { return $this->valor; }
    public function getCliente(): string { return $this->cliente; }
    public function getPuesto(): string { return $this->puesto; }
    public function getAvion(): string { return $this->avion; }
    public function getAeropuertoSalida(): string { return $this->aeropuertoSalida; }
    public function getAeropuertoLlegada(): string { return $this->aeropuertoLlegada; }
    public function getPiloto(): string { return $this->piloto; }
}