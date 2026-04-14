<?php

class EditVueloService implements EditVueloPort {
    
    public function __construct(
        private VueloRepository $repository
    ) {}

    public function execute(EditVueloCommand $command): void {
        //Convertimos el ID a Value Object para validar formato
        $vueloId = new VueloId($command->getId());

        //Creamos el modelo con los nuevos datos (incluyendo el ID existente)
        // Usamos el Factory Method que definiste en tu modelo
        $vuelo = VueloModel::create([
            'id' => $command->getId(),
            'fechaCompra' => $command->getFechaCompra(),
            'fechaSalida' => $command->getFechaSalida(),
            'fechaLlegada' => $command->getFechaLlegada(),
            'agenciaViajes' => $command->getAgenciaViajes(),
            'aerolinea' => $command->getAerolinea(),
            'numero' => $command->getNumero(),
            'estado' => $command->getEstado(),
            'valor' => $command->getValor(),
            'cliente' => $command->getCliente(),
            'puesto' => $command->getPuesto(),
            'avion' => $command->getAvion(),
            'aeropuertoSalida' => $command->getAeropuertoSalida(),
            'aeropuertoLlegada' => $command->getAeropuertoLlegada(),
            'piloto' => $command->getPiloto()
        ]);

        //Persistimos los cambios llamando al puerto de salida (Repository)
        $this->repository->update($vuelo);
    }
}