<?php
class VueloModel {
    public function __construct(
        private VueloId $id,
        private string $fechaCompra,
        private string $fechaSalida,
        private string $fechaLlegada,
        private string $agenciaViajes,
        private string $aerolinea,
        private string $numero,
        private string $estado,
        private VueloValor $valor,
        private string $cliente,
        private string $puesto,
        private string $avion,
        private string $aeropuertoSalida,
        private string $aeropuertoLlegada,
        private string $piloto
    ) {
        VueloEstadoEnum::ensureIsValid($estado);
    }

    // Getters para acceder a los datos
    public function id(): VueloId { 
        return $this->id; 
    }
    public function numero(): string { 
        return $this->numero; 
    }
    public function valor(): VueloValor { 
        return $this->valor; 
    }
    public function estado(): string { 
        return $this->estado; 
    }
    public function fechaSalida(): string { 
        return $this->fechaSalida; 
    }
    public function fechaLlegada(): string { 
        return $this->fechaLlegada; 
    }
    public function aerolinea(): string { 
        return $this->aerolinea; 
    }
    public function agenciaViajes(): string { 
        return $this->agenciaViajes; 
    }
    public function cliente(): string {
        return $this->cliente; 
    }
    public function puesto(): string { 
        return $this->puesto; 
    }
    public function avion(): string { 
        return $this->avion; 
    }
    public function aeropuertoSalida(): string { 
        return $this->aeropuertoSalida; 
    }
    public function aeropuertoLlegada(): string { 
        return $this->aeropuertoLlegada; 
    }
    public function piloto(): string { 
        return $this->piloto; 
    }
    public function fechaCompra(): string { 
        return $this->fechaCompra; 
    }

    // Método estático para crear un vuelo nuevo (Factory)
    public static function create(array $data): self {
        return new self(
            new VueloId($data['id']),
            $data['fechaCompra'],
            $data['fechaSalida'],
            $data['fechaLlegada'],
            $data['agenciaViajes'],
            $data['aerolinea'],
            $data['numero'],
            $data['estado'],
            new VueloValor($data['valor']),
            $data['cliente'],
            $data['puesto'],
            $data['avion'],
            $data['aeropuertoSalida'],
            $data['aeropuertoLlegada'],
            $data['piloto']
        );
    }
}