<?php
class GetVueloByIdService implements GetVueloByIdPort { // <--- Implementa el puerto
    public function __construct(
        private VueloRepository $repository
    ) {}

    public function execute(string $id): ?VueloModel {
        return $this->repository->findById(new VueloId($id));
    }
}