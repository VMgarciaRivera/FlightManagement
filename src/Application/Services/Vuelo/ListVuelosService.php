<?php

class ListVuelosService implements ListVuelosPort {
    
    public function __construct(
        private VueloRepository $repository
    ) {}

    /**
     * @return VueloModel[]
     */
    public function execute(): array {
        // Llama al puerto de salida para obtener la colección de modelos
        return $this->repository->findAll();
    }
}