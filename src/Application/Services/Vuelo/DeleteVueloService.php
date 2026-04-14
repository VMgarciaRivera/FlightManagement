<?php
class DeleteVueloService implements DeleteVueloPort {
    public function __construct(
        private VueloRepository $repository
    ) {}

    public function execute(DeleteVueloCommand $command): void {
        // Validamos el ID convirtiéndolo a Value Object
        $vueloId = new VueloId($command->getId());
        
        // Ejecutamos la eliminación en el repositorio
        $this->repository->delete($vueloId);
    }
}