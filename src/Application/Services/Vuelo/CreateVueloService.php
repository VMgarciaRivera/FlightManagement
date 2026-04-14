<?php
class CreateVueloService implements CreateVueloPort { // <--- Implementa el puerto
    public function __construct(
        private VueloRepository $repository
    ) {}

    public function execute(CreateVueloCommand $command): void {
        $data = $command->getData();
        $vuelo = VueloModel::create($data);
        $this->repository->save($vuelo);
    }
}