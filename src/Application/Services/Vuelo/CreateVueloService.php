<?php
class CreateVueloService {
    // Inyectamos la interfaz (el puerto de salida)
    public function __construct(
        private VueloRepository $repository
    ) {}

    public function execute(CreateVueloCommand $command): void {
        $data = $command->getData();
        
        // 1. El Dominio crea el modelo y valida las reglas
        $vuelo = VueloModel::create($data);

        // 2. Se persiste usando el puerto
        $this->repository->save($vuelo);
    }
}